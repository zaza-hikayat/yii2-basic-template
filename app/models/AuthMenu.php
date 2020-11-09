<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%auth_menu}}".
 *
 * @property int $id
 * @property int $role_name
 * @property int $menu_id
 */
class AuthMenu extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%auth_menu}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['menu_id'], 'default', 'value' => null],
			[['menu_id'], 'integer'],
			[['role_name'], 'string'],
			[['menu_id', 'role_name'], 'required'],

		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'role_name' => 'Role',
			'menu_id' => 'Menu ID',
		];
	}

	public function beforeSave($insert)
	{
		self::getDb()->createCommand("update m_menu set updated_at = :date where id =:id", [":date" => date("Y-m-d H:i"), ":id" => $this->menu_id])->execute();
		return parent::beforeSave($insert); // TODO: Change the autogenerated stub
	}

	public function getRole()
	{
		return $this->hasOne(AuthItem::className(), ['name' => 'role_name']);
	}

	public function getMenu()
	{
		return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
	}

}