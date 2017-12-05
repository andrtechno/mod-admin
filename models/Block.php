<?php

namespace panix\mod\admin\models;

use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\i18n\Formatter;

/**
 * This is the model class for table "{{%block}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $format
 * @property integer $active
 * @property integer $created_at
 * @property integer $updated_at
 */
class Block extends \panix\engine\db\ActiveRecord {

    const FORMAT_TEXT = 'text';
    const FORMAT_HTML = 'html';
    const FORMAT_RAW = 'raw';

    /**
     * @var array|Formatter the formatter used to format model attribute values into displayable texts.
     * This can be either an instance of [[Formatter]] or an configuration array for creating the [[Formatter]]
     * instance. If this property is not set, the "formatter" application component will be used.
     */
    public $formatter;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%block}}';
    }
    public function getPaymentSystemsArray() {
        Yii::import('app.blocks_settings.*');
        $result = array();
        $systems = new WidgetSystemManager;
        foreach ($systems->getSystems() as $system) {
            $result[(string) $system->id] = $system->name;
        }
        return $result;
    }
    protected function initFormatter() {
        if ($this->formatter === null) {
            $this->formatter = Yii::$app->getFormatter();
        } elseif (is_array($this->formatter)) {
            $this->formatter = Yii::createObject($this->formatter);
        }

        if (!$this->formatter instanceof Formatter) {
            throw new InvalidConfigException('The "formatter" property must be either a Format object or a configuration array.');
        }
    }

    public static function getFormatsList() {
        return [
            self::FORMAT_TEXT => self::FORMAT_TEXT . ' (' . Yii::t('blocks', 'Formats the value as an HTML-encoded plain text') . ')',
            self::FORMAT_HTML => self::FORMAT_HTML . ' (' . Yii::t('blocks', 'Formats the value as HTML text') . ')',
            self::FORMAT_RAW => self::FORMAT_RAW . ' (' . Yii::t('blocks', 'Formats the value as is without any formatting') . ')'
        ];
    }

    public static function render($blockId) {
        if (is_numeric($blockId)) {
            $model = self::findById($blockId);
        } else {
            $model = self::findBySystemName($blockId);
        }

        if ($model instanceof Block) {
            return $model->renderProcess();
        }
    }

    protected function renderProcess() {
        $this->initFormatter();
        return $this->renderContent();
    }

    protected function renderTitle() {
        return !empty($this->title) ? $this->title : '';
    }

    protected function renderContent() {
        return $this->formatter->format($this->content, $this->format);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['format'], 'required'],
            [['content','widget'], 'string'],
            [['active', 'created_at', 'updated_at'], 'integer'],
            [['title', 'format'], 'string', 'max' => 255]
        ];
    }

    public function behaviors() {
        return [
            'timestampable' => [
                'class' => TimestampBehavior::className(),
            ]
        ];
    }

    public static function findBySystemName($name) {
        $model = null;

        $template = "/block_([0-9]*)/";
        preg_match_all($template, $name, $result);

        if (!empty($result[1][0])) {
            $model = self::findById($result[1][0]);
        }

        if ($model === null) {
            Yii::warning("Block with system name = $name not found", 'yii2-block');
        }

        return $model;
    }

    public static function findById($id) {
        $model = self::findOne((int) $id);

        if ($model === null) {
            Yii::warning("Block with id = $id not found", 'yii2-block');
        }

        return $model;
    }

    public function getSystemName() {
        return 'block_' . $this->id;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('blocks', 'ID'),
            'title' => Yii::t('blocks', 'Title'),
            'content' => Yii::t('blocks', 'Content'),
            'format' => Yii::t('blocks', 'Format'),
            'active' => Yii::t('blocks', 'Active'),
            'created_at' => Yii::t('blocks', 'Created at'),
            'updated_at' => Yii::t('blocks', 'Updated at'),
        ];
    }

    /**
     * @inheritdoc
     * @return BlockQuery the active query used by this AR class.
     */
    public static function find() {
        return new query\BlockQuery(get_called_class());
    }

}
