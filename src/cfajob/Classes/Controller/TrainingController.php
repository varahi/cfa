<?php
namespace T3Dev\Cfajob\Controller;

/***
 *
 * This file is part of the "CFA Job" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 Dmitry Vasilev <dmitry@t3dev.ru>, T3Dev
 *
 ***/
/**
 * TrainingController
 */
class TrainingController extends AbstractController
{

    /**
     * trainingRepository
     *
     * @var \T3Dev\Cfajob\Domain\Repository\TrainingRepository
     */
    protected $trainingRepository = null;

    /**
     * @param \T3Dev\Cfajob\Domain\Repository\TrainingRepository $trainingRepository
     */
    public function injectTrainingRepository(\T3Dev\Cfajob\Domain\Repository\TrainingRepository $trainingRepository)
    {
        $this->trainingRepository = $trainingRepository;
    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $trainings = $this->trainingRepository->findAll();
        $this->view->assign('trainings', $trainings);

        // Find selected city by trainings
        foreach ($trainings as $training) {
            $trainingUids[] = $training->getCity()->getUid();
        }
        $cities = $this->locationRepository->findByUids($trainingUids);
        $this->view->assign('cities', $cities);
    }

    /**
     * action show
     *
     * @param \T3Dev\Cfajob\Domain\Model\Training $training
     * @return void
     */
    public function showAction(\T3Dev\Cfajob\Domain\Model\Training $training)
    {
        $this->view->assign('training', $training);
    }
}
