<?php

/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */


namespace Zemit\Bootstrap\Permissions;

use Zemit\Models\SurveyAiAnswer;
use Zemit\Modules\Api\Controllers\SurveyAiAnswerController;
use Phalcon\Config as PhalconConfig;
use Zemit\Config\Config as ZemitConfig;
use Zemit\Mvc\Controller\Behavior\Skip\SkipIdentityCondition;
use Zemit\Mvc\Controller\Behavior\Skip\SkipSoftDeleteCondition;
use Zemit\Modules\Api\Controllers\SurveyAiQuestionController;
use Zemit\Modules\Api\Controllers\SurveyAnswerController;
use Zemit\Modules\Api\Controllers\SurveyController;
use Zemit\Models\SurveyAiQuestion;
use Zemit\Models\SurveyQuestion;
use Zemit\Models\SurveyChoice;
use Zemit\Models\SurveyAnswer;
use Zemit\Models\SurveyGroup;
use Zemit\Models\Survey;

class SurveyConfig extends ZemitConfig
{
    public function __construct(array $data = [], bool $insensitive = true)
    {
        parent::__construct([
            'permissions' => [
                'features' => [

                    'viewSurveyList' => [
                        'components' => [
                            Survey::class => ['find'],
                            SurveyGroup::class => ['find'],
                            SurveyQuestion::class => ['find'],
                            SurveyChoice::class => ['find'],
                            SurveyAnswer::class => ['find'],
                        ],
                    ],

                    'manageSurveyList' => [
                        'components' => [
                            Survey::class => ['*'],
                            SurveyController::class => ['*'],
                            SurveyGroup::class => ['*'],
                            SurveyQuestion::class => ['*'],
                            SurveyChoice::class => ['*'],
                            SurveyAnswer::class => ['*'],
                        ],
                        'behaviors' => [
                            SurveyController::class => [
                                SkipIdentityCondition::class,
                                SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],

                    'saveSurveyAnswer' => [
                        'components' => [
                            SurveyAnswerController::class => ['get-all', 'save'],
                            SurveyAnswer::class => ['find', 'create', 'update'],
                        ],
                    ],


                    'manageSurveyAiQuestion' => [
                        'components' => [
                            SurveyAiQuestionController::class => ['*'],
                            SurveyAiQuestion::class => ['*'],
                        ],
                        'behaviors' => [
                            SurveyAiQuestionController::class => [
                                SkipIdentityCondition::class,
                                SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],

                    'manageSurveyAiAnswer' => [
                        'components' => [
                            SurveyAiAnswerController::class => ['*'],
                            SurveyAiAnswer::class => ['*'],
                        ],
                        'behaviors' => [
                            SurveyAiAnswerController::class => [
                                SkipIdentityCondition::class,
                                SkipSoftDeleteCondition::class,
                            ],
                        ],
                    ],

                ],

                'roles' => [

                    'user' => [
                        'features' => [
                            'viewSurveyList',
                            'manageSurveyAiAnswer',
                        ],
                    ],

                    'researcher' => [
                        'features' => [
                            'saveSurveyAnswer',
                        ],
                    ],

                    'leader' => [
                        'features' => [
                            'manageSurveyList',
                            'manageSurveyAiQuestion',
                        ],
                    ],

                ],
            ],
        ], $insensitive);

        if (!empty($data)) {
            $this->merge(new PhalconConfig($data, $insensitive));
        }
    }
}
