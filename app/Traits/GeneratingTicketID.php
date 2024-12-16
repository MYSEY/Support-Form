<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\GenerateIdEmployee;

trait GeneratingTicketID
{
   
    //*** Generate employee
    public function generateTicketID()
    {
        $currentYear = Carbon::now();
        $count = 0;
        $geticketID = Ticket::orderBy('id','DESC')->select('trackid')->get();
        if (!empty($geticketID)) {
            for ($i = 0; $i < count($geticketID); $i++) {
                // $current = $geticketID[$i]->trackid;
                $current = (int) substr($geticketID[$i]->trackid,4);
                if ($i + 1 < count($geticketID)) {
                    $next = (int) substr($geticketID[$i + 1]->trackid,4);
                }
                
                if (isset($next) && $current + 1 != $next) {
                    $count = (int) substr($geticketID[$i]->trackid,4);
                    // $count = (int) substr(strrchr($geticketID[$i]->trackid, "0"), 1);
                    break;
                } else {
                    // $count = (int) substr($geticketID[$i]->trackid,1);
                    $count = (int) substr($geticketID[$i]->trackid,4);
                }
            }
        }
        do {
            $ticketID = $currentYear->format('ymd').str_pad(($count+ 1), 2, "0", STR_PAD_LEFT);
            $alreadyExist = Ticket::select('trackid')->where('trackid', $ticketID)->first()->trackid ?? null;
            $count++;
        } while ($alreadyExist);
        return $ticketID;
    }
}
