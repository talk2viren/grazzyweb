<?php if(!defined('BASEPATH')) exit('No direct script allowed access');
class Api_model extends CI_Model
{
	public function getUsers(){
		
		$threadmsg = $this->db->query("select * from customers");

			if($threadmsg->num_rows()>0){

				return $threadmsg->result_array();

			}else{
			
				return false;
				
			}
			
		
	}
	
	
	public function RestaurantMenuDetails($input_data){
		
		$sql=$this->db->query("select id,name,logo  from restaurants where id=".$input_data);
		$i=0;
		if($sql->num_rows()>0){
			$result[$i] = true;
			$data = $sql->result_array();
			$result['data']['ID'] = $data[0]['id'];
			$result['data']['RestaurantName'] = $data[0]['name'];
			$restorent_logo_path=$data[0]['logo'];
			$restorent_logo_path=$this->config->base_url()."images/".$restorent_logo_path;
			$result['data']['Image']=$restorent_logo_path;
			

			$group_sql = $this->db->query("select * from groups where restaurant_id=".$data[0]['id']);	

			$group_count=0;
			foreach($group_sql->result_array() as $group_data){

			    $result['data']['RestaurantMenu'][$group_count]['ID'] = $group_data['id'];
			    $result['data']['RestaurantMenu'][$group_count]['Name'] = $group_data['name'];
			    
				$dish_sql = $this->db->query("select * from dishes join dish_prices on dishes.id= dish_prices.dish_id where dishes.restaurant_id=".$group_data['restaurant_id']." and dishes.group_id=".$group_data['id']);

				//echo $this->db->last_query();

				$dish_count=0;
				foreach($dish_sql->result_array() as $dish_data){

//
					$dish_logo_path=$dish_data['image'];
					$dish_logo_path=$this->config->base_url()."images/".$dish_logo_path;
				
					//print_r($dish_data); exit;

					$result['data']['RestaurantMenu'][$group_count]['CategoryDish'][$dish_count]['ID'] = $dish_data['id'];
			    	$result['data']['RestaurantMenu'][$group_count]['CategoryDish'][$dish_count]['DishName'] = $dish_data['name'];
			    	$result['data']['RestaurantMenu'][$group_count]['CategoryDish'][$dish_count]['Image'] = $dish_logo_path;
			    	$result['data']['RestaurantMenu'][$group_count]['CategoryDish'][$dish_count]['Description'] = $dish_data['description'];
			    	$result['data']['RestaurantMenu'][$group_count]['CategoryDish'][$dish_count]['Rate'] = 'KD '.$dish_data['price'];

			    	$dish_count++;

				}
					
				$group_count++;
			}

//		print_r($result);
//	print_r("\n");	
//		print_r($group_count);
//	print_r("service model BASE URL @@@");exit();

		}else{
			$result[0] = false;
		}	
		return json_encode($result);
	}
}