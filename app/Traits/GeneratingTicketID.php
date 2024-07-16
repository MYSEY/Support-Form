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
        $geticketID = Ticket::orderBy('trackid','DESC')->select('trackid')->get();
        if (!empty($geticketID)) {
            for ($i = 0; $i < count($geticketID); $i++) {
                $current = (int) substr(strrchr($geticketID[$i]->trackid, "-"), 1);
                if ($i + 1 < count($geticketID)) {
                    $next = (int) substr(strrchr($geticketID[$i + 1]->trackid, "-"), 1);
                }
                
                if (isset($next) && $current + 1 != $next) {
                    $count = (int) substr(strrchr($geticketID[$i]->trackid, "-"), 1);
                    break;
                } else {
                    $count = (int) substr(strrchr($geticketID[$i]->trackid, "-"), 1);
                }
            }
        }
        do {
            $ticketID = $currentYear->format('y').'-'.str_pad(($count + 1), 6, "0", STR_PAD_LEFT);
            $alreadyExist = Ticket::select('trackid')->where('trackid', $ticketID)->first()->trackid ?? null;
            $count++;
        } while ($alreadyExist);
        return $ticketID;
    }
}
