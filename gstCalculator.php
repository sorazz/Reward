
<?php 
   

   use App\Http\Controllers\Controller;
   use Illuminate\Http\Request;
   
   
 class GSTCalculateController extends Controller
{

	public function calulateGst(Request $request)
	{
	  
	  $gstrate = $request->gst_rate;
	  
	  $gstInclusiveAmount = $request->amount;
	  
	  $basicAmount = $gstInclusiveAmount * 100 / (100 + $gstrate );
	  
	  $gstAmount = $request->amount - $basicAmount;
		
	  echo $gstAmount;

	}
}

?>