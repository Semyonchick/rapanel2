<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 14.09.2015
 * Time: 11:47
 */

namespace app\admin\components;

use app\admin\models\Cart;
use yii\base\Component;

class ShoppingCart extends Component
{
    public $attributes;
    private $_items;

    public function put($model, $quantity = 1)
    {
        $this->update($model, $quantity, true);
    }

    /**
     * @param $model \app\admin\traits\CartItem
     */
    public function update($model, $quantity, $add = false)
    {
        foreach ($this->getItems() as $row)
            if ($row->item_id == $model->getId()) {
                $item = $row;
                break;
            }
        if (isset($item) && !$quantity) {
            $item->delete();
            return;
        }
        if (empty($item)) {
            $item = new Cart;
            $item->data = serialize($model);
            $item->setAttributes(['session_id' => $this->getSessionId(), 'item_id' => $model->getId(), 'status' => 0, 'order_id' => 0], false);
        }
        $item->price = $model->getPrice();
        $item->quantity = $add ? ($item->quantity + $quantity) : $quantity;
        $item->save(false);
    }

    public function getItems()
    {
        if (!$this->_items)
            $this->_items = Cart::findAll(['session_id' => $this->getSessionId(), 'status' => 0, 'order_id' => 0]);
        return $this->_items;
    }

    public function getQuantity()
    {
        $quantity = 0;
        foreach ($this->getItems() as $row)
            $quantity += $row['quantity'];
        return $quantity;
    }

    public function getCount()
    {
        return count($this->getItems());
    }

    public function getCost()
    {
        $total = 0;
        foreach ($this->getItems() as $row)
            $total += $row['price'] * $row['quantity'];
        return $total;
    }

    public function clear()
    {
        foreach ($this->getItems() as $row)
            $row->delete();
        $this->_items = false;
    }

    public function toOrder($order_id)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        foreach ($this->getItems() as $row) {
            $row->status = 1;
            $row->order_id = $order_id;
            $row->update(false, ['status', 'order_id']);
        }
        $this->_items = false;
        $transaction->commit();
    }

    public function getSessionId()
    {
        return \Yii::$app->user->getId() ?: \Yii::$app->session->hasSessionId || !\Yii::$app->session->open() ? \Yii::$app->session->getId() : '';
    }
}