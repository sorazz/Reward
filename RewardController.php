<?php 
   
   use Models\Order;
   use Models\Customer;
   use Models\Reward;
   use Request;
   use Carbon\Carbon;
   use Auth;
   
 class RewardController 
{

	public function reward(Request $request)
	{

		try{
			   $order = Order::where('customer_id',$request->customer_id)->get();
			   $customer = Customer::find($request->customer_id);
			   if($order->status == 'complete')
			   {
					$rewardAmount = $order->amount;
					if($order->amount_currency  == "USD")
					{
							$customer->reward->update([
							'reward_point' => $customer->reward->reward_point + $reward,
							'reward_expire_date' =>Carbon::now()->addYears(1);
							'reward_amount' =>$customer->reward->reward_amount + $reward * 0.01;
							
							]);
					}
					else
					{
						$usdAmount = $this->exchangeCurrency($order);
						$customer->reward->update([
							'reward_point' =>$customer->reward->reward_point + round($usdAmount),
							'reward_expire_date' =>Carbon::now()->addYears(1);
							'reward_amount' =>$customer->reward->reward_amount +round($usdAmount) * 0.01;
							
							]);
						
					}
			   }
			 }
			 catch(/Exception $e)
			 {
			 	return $e->message();
			 }
	
	}
	
	public function exchangeCurrency($data) {

	Next, Go to this link https://free.currencyconverterapi.com/ and get API Key. Because when we will call the API, need put to API key into this.
      $amount = $data['amount'];

      $apikey = 'd1ded944220ca6b0c442';

      $from_Currency = urlencode($request->from_currency);
      $to_Currency = urlencode("USD");
      $query = "{$from_Currency}_{$to_Currency}";

      $json = file_get_contents("http://free.currencyconverterapi.com/api/v5/convert?q={$query}&amp;compact=y&amp;apiKey={$apikey}");

      $obj = json_decode($json, true);

      $val = $obj["$query"];

      $total = $val['val'] * 1;

      $formatValue = number_format($total, 2, '.', '');

      $data = "$amount $from_Currency = $to_Currency $formatValue";

      return $data;

   }

   public function useReward(Request $request)
   {

   	try{
   		$customer = Customer::find($request->customer_id);
	   	  $useRewardPoint = $request->reward_point;
	   	  $remainingRewardPoint = $customer->reward->reward_point - $request->reward_point;
	   	  $customer->reward->update([
	        
	         'reward_point' => $remainingRewardPoint
	         'reward_amount' => $remainingRewardPoint * 0.01

	   	  	]);
   	}
   	catch(/Exception $e)
   	{
   		return $e->message();
   	}

   	  
   }

   
}




?>