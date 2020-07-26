<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;


use App\Http\Requests\getaRoomReq;
use App\Http\Requests\roomIdReq;


use App\Room;
use App\reservation;

use Carbon\Carbon;
use Redirect;


use App\Jobs\SendMailReservation;



class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


  public $totalDatesPerRoom = array();		
  public $roomsReservations = array();		
	public $newDatas = array();		
	public $datesGenAa = array();
	public $datesGenAb = array();


				function __construct() {
						$this->Room = new Room();
						$this->reservation = new reservation();
				} /* end of a constructor function*/ 






    /* reserevation dates generator startDate, enddate, return all dates in between */
          function generateDateRange(Carbon $start_date, Carbon $end_date)
                {
                    $dates = array();	

                    for($date = $start_date->copy(); $date->lte($end_date); $date->addDay()) {
												 $dates[] = $date->format('d-m-Y');
                    }

                    return $dates;
         }/* end of generateDateRange */



           /* function does populate variable $totalDatesPerRoom with all reservate dates per room */

            function pushToTotalDatesAlreadyReservate($datesa){
           
		            foreach($datesa as $date){
				          if(is_string($date)){
				                   array_push($this->totalDatesPerRoom, $date);                               
				            }  
		            } /* end foreach */
         
             
         	 } /* end of pushToTotalDatesAlreadyReservate */


   















	public function getRoom(getaRoomReq $request) {


      /*  check if room is still available date */  

            /* check based on room ID */
            $validatedData = $request->validated();
				        $roomName = $validatedData['soba'];
       
						
             	$roomIdRef = $this->Room::where('Ime sobe', '=', $roomName)->first();
             $roomCheckDate = $this->reservation::where('sobeId', '=', $roomIdRef["id"])->get();
        
      
   					/* verification if room date is still available */
      
            foreach ($roomCheckDate as $sd) {
          
            $startDatea = \Carbon\Carbon::createFromFormat('Y-m-d',substr($sd['datumPrihod'], 0, 10));
            $endDatea = \Carbon\Carbon::createFromFormat('Y-m-d',substr($sd['datumOdhod'], 0, 10));

            /* 
					datumi prihod odhod in vmesni zasedenosti sobe od enega preveri in od danes dalje preveri ker za nazaj se ne da zasesti sobe ... 						*/          
             
             $datesa = $this->generateDateRange($startDatea, $endDatea);

             $this->pushToTotalDatesAlreadyReservate($datesa);
        
            } /* end foreach */

          

          /*  block of code generating to be reservate rooms dates */ 
   
   				/* specific date format using carbon */
      $startDateb = \Carbon\Carbon::createFromFormat('Y-m-d',substr($validatedData['datumPrihod'], 0, 10));
      $endDateb = \Carbon\Carbon::createFromFormat('Y-m-d',substr($validatedData['datumOdhod'], 0, 10));

      $toBeReservateDates = $this->generateDateRange($startDateb,$endDateb);
      
 
          /* end of block of code  generating to be reservate rooms dates*/ 




    /* compare selected dates with reservated dates  */
    /* functionlity responsible for comparing an array of values in our case dates */
      

         $result=array_intersect($this->totalDatesPerRoom, $toBeReservateDates);
          if(!empty($result)){
              	return redirect()->back()->with('success', 'datum je ze rezerviran!'); 
                 die();  
          };
         
       
           
     /* end of functionlity responsible for comparing an array of values in our case dates */




       	$idSobe = $this->Room::where('Ime sobe', '=', $validatedData['soba'])->first();



				$this->reservation->datumPrihod = $startDateb;
				$this->reservation->datumOdhod = $endDateb;
				$this->reservation->sobeId = $idSobe['id'];
				$this->reservation->ImePriimek = $validatedData['ImePriimek'];		
				$this->reservation->email = $validatedData['email'];
				$this->reservation->telNumber = $validatedData['telNumber'];
				$this->reservation->opomba = $validatedData['opomba'];		   
				$this->reservation->save();
			
       
        /* stevilo dni */
      	 $different_days = $startDateb->diffInDays($endDateb);


        /* CENA SOBE */
         /* KALKULACIJA RACUNA */
          $cena = $this->Room::where('id', '=', $idSobe['id'])->first();
          
       

        /* cena za vse dni */
         $skupajCena =  $cena["cena / noč"] * $different_days;
  

  

         $emaildata[0] = $startDateb;
         $emaildata[1] = $endDateb;
				 $emaildata[2] = $validatedData['ImePriimek'];
         $emaildata[3] = $different_days;

         $emaildata[4] = $validatedData['soba'];
         $emaildata[5] = $cena["cena / noč"];
         $emaildata[6] = $skupajCena;
		 		 $emaildata[7] = $validatedData['email'];
    
    
      
			dispatch(new SendMailReservation($emaildata))->delay(10);
		

					return redirect()->back()->with('success', 'hvala za najem');   


	}		/* end of getRoom function */

















	public function getRoomsSubIds() {

			/* later on could be fetched from database */
			$roomsIds = [1,2,3,4,5,6];

			foreach($roomsIds as $id){
			$idrooms = $id -1;
				$rooms[$idrooms] = $this->reservation::where('sobeId', '=', $id)->get();
			}
			return $rooms;
		
	} /*  end of function getRoomsSubIds */







/* removeFirstZeroFromMonth and day also */
public function removeFirstZeroFromMonth($roomsReservationsItem) {
		
		$expRR = array();

				foreach($roomsReservationsItem as $Item){
				
					$exp = explode("-",$Item);		
					$expA = ltrim($exp[0], '0');	
					$expB = ltrim($exp[1], '0');

					$arr[0] = $expA;		
					$arr[1] = $expB;
					$arr[2] = $exp[2];
					$expR = implode("-",$arr);
				 array_push($expRR,$expR);
						
		
				}/* end of foreach function */
		return $expRR;	


	}	/* end of removeFirstZeroFromMonth function */








/* restructuring dates to single array */

public function singleArrayDate($dates){
		/* dates are arrays holding dates as values */
		foreach($dates as $date){
				array_push($this->datesGenAa, $date);
		}
			return $this->datesGenAa;
} 	/* end of singleArrayDate function */






/*

public function concatD($ro){
		foreach($ro as $ss){
		array_push($this->datesGenAb, $ss);
	}
} */	/* end of concatD function */




 public function roomGetDatesReseve($room, $key){

	
		foreach($room as $date){

				 $ddc = Carbon::createFromFormat('Y-m-d',substr($date["datumPrihod"], 0, 10));
				 $dec = Carbon::createFromFormat('Y-m-d',substr($date["datumOdhod"], 0, 10));
				 $bew = $this->generateDateRange($ddc, $dec);
				
				$qqq = $this->singleArrayDate($bew);
				
		} /* end for each */

				$sss = $this->datesGenAa;
				$this->datesGenAa = [];
		return $sss;
		

	}	/* end of roomGetDatesReseve function */










		public function welcome() {

					$roomsA = $this->Room->get();
					foreach($roomsA AS $key => $f){ 
							$roomsIme[$key]["name"] = $f['Ime sobe'];
							$roomsIme[$key]["id"] = $f['id'];
					}
    	

			$rooms = $this->getRoomsSubIds();
				 foreach($rooms AS $key => $room){ 			
					$this->roomsReservations[$key] = $this->roomGetDatesReseve($room, $key);
				 		
				}


	
	/* do not forget to return only dates from current day on not dates in the past ...*/

		$roomsReservations = $this->roomsReservations;

			foreach($roomsReservations AS $key => $roomsRese){
				$roo[$key] = $this->removeFirstZeroFromMonth($roomsRese);
			}

	

		return view('welcome', compact(['roomsIme', 'roomsReservations', 'roo']));

		}	/* end of welcome function */


	





		public function cenaSobeNaNoc($sobeId) {
			$cenaSobeNaNoc = $this->Room::where('id', '=', $sobeId)->first();
				return $cenaSobeNaNoc["cena / noč"];
		}	/* end of cenaSobeNaNoc function */







public function vsakaSobaPosebejIzpisA($reservation) {
		
		$newDataReservation = array();		
	
				/* klic funkcije za izracun stevila dni in cena */
					 if(!empty($reservation)){
					
						   $ddd = Carbon::createFromFormat('Y-m-d',substr($reservation["datumPrihod"], 0, 10));
						   $ded = Carbon::createFromFormat('Y-m-d',substr($reservation["datumOdhod"], 0, 10));
						  	$reservation["steviloDni"] = count($this->generateDateRange($ddd, $ded)); 
								$reservation["celotniCena"] = $reservation["steviloDni"] * $this->cenaSobeNaNoc($reservation["sobeId"]);
							return $reservation;
          };
				
			

}	/* end of vsakaSobaPosebejA Izpis function */







public function roomIterator($room) {
		
		$a = array();
				foreach ($room as $roomIdAssoci) {
			
				/* klic funkcije za izracun stevila dni in cena */
					
					 if(!empty($roomIdAssoci)){		
							$b = $this->vsakaSobaPosebejIzpisA($roomIdAssoci);
								
							array_push($a,$b);		
											
						};/* end of if*/ 
				}; /* end for each */

			
			$this->newDatas[] = $a;
		
}	/* end of roomIterator  function */







	 public function admin() {

			$rooms = $this->getRoomsSubIds();

				foreach ($rooms as $room)
				{
				/* klic funkcije za izracun stevila dni in cena */
					 if(!empty($room)){
			
								$this->roomIterator($room);
						}; 

				}; /* end for each */

    
			return $this->newDatas;



		}	/* end of admin function */






	public function adminDash() {
			$roomsDataNew = array();

		
		$roomsDataLatest = $this->reservation->orderBy('created_at', 'desc')->paginate(12);

		foreach($roomsDataLatest as $roomRes){
				$b = $this->vsakaSobaPosebejIzpisA($roomRes);
				array_push($roomsDataNew,$b);
		}
	

		return view('dashboard', compact(['roomsDataLatest']));
	}	/* end of adminDash function */




public static function getRoomNameById($roomId) {
			$Room = new Room();
			$roome = $Room::where('id', '=', $roomId)->first(); 
			return $roome['Ime sobe'];
	}	/* end of getRoomNameById function */




public function removeReservation(roomIdReq $request, $id) {
				 $this->reservation::where('id', '=', $request['id'])->delete();
			    return Redirect::back()->with('success', 'reservation successfully removed');
}	/* end of removeReservation function */





}

		
			
