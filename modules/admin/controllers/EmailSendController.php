<?php

namespace lo\modules\email\modules\admin\controllers;

use lo\core\helpers\CalculationHelper;
use lo\core\modules\settings\actions\Settings;
use lo\core\modules\settings\models\FormModel;
use lo\modules\email\adapters\EmailSettingsInterface;
use lo\modules\email\forms\SparkpostForm;
use Yii;
use yii\web\Controller;

/**
 * Class EmailSendController
 * @package lo\modules\email\modules\admin\controllers
 * @author Lukyanov Andrey <loveorigami@mail.ru>
 */
class EmailSendController extends Controller
{
    const START_SEND = 'backend.email.start_send';
    const END_SEND = 'backend.email.end_send';

    private $_settings;

    public function __construct($id, $module, EmailSettingsInterface $settings, $config = [])
    {
        $this->_settings = $settings;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'settings' => [
                'class' => Settings::class,
                'keys' => [
                    'backend.email.send_session' => [
                        'label' => Yii::t('backend', 'Send session'),
                        'type' => FormModel::TYPE_TEXTINPUT,
                    ],
                    self::START_SEND => [
                        'label' => Yii::t('backend', 'Send start'),
                        'type' => FormModel::TYPE_TEXTINPUT,
                    ],
                    self::END_SEND => [
                        'label' => Yii::t('backend', 'Send end'),
                        'type' => FormModel::TYPE_TEXTINPUT,
                    ],
                ]
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $start_send = $this->_settings->get(self::START_SEND);
        $end_send = $this->_settings->get(self::END_SEND);
        $persent = CalculationHelper::getPersent($start_send, $end_send);

        $model = new SparkpostForm();
        $model->start_send = $start_send;
        $model->end_send = $end_send;

        if ($model->load(Yii::$app->request->post())) {
            $model = new SparkpostForm(); //reset model
            $persent = 10;
            if (Yii::$app->request->isPjax) {
                $persent = 10;
            }
        }

        return $this->render('index', ['model' => $model, 'persent' => $persent]);
    }

}
