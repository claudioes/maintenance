<?php namespace Stevebauman\Maintenance\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class InventoryStockMovement extends Eloquent {
	
	protected $table = 'inventory_stock_movements';
	
        protected $fillable = array(
            'stock_id', 
            'user_id',
            'before',
            'after',
            'cost',
            'reason',
        );
        
        public function user(){
		return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'user_id');
	}
        
        public function getChangeAttribute(){
            if($this->before > $this->after){
                return $this->before - $this->after;
            } else{
                return $this->after - $this->before;
            }
        }
        
}