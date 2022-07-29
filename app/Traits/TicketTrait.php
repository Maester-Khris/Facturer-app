<?php

namespace App\Traits;
use App\Models\Ticket;
use Carbon\Carbon;

trait TicketTrait {
      public static function getAllTickets($id_depot){ }

      public static function getTicketByDepot($code, $id_depot){
            $ticket = Ticket::where('code_ticket',$code)
                  ->with('comptoir', function($query) use ($id_depot){
                        $query->where('depot_id','=',$id_depot);
                  })->first(); 

            return $ticket;
      }
      public static function getAllTicketsByDepot($id_depot){
            $tickets = Ticket::with('comptoir', function($query) use ($id_depot){
                  $query->where('depot_id','=',$id_depot);
            })->get(); 
            return $tickets;
      }
      public static function getAllTicketArchivesByDepot($id_depot, $periode_min, $periode_max){
            $tickets = Ticket::where('statut','archive')
            ->with('comptoir', function($query) use ($id_depot, $periode_min, $periode_max){
                  $query->where('depot_id','=',$id_depot);
            })
            ->whereBetween('date_operation', [$periode_min, Carbon::parse($periode_max)->endOfDay()])
            ->get(); 
            return $tickets;
      }

      public static function getTicketArchiveByComptoir($caisse, $periode_min, $periode_max){
            $comptoirids = $caisse->comptoirs->map(function($item){
                  return $item->id;
            });
            $tickets = Ticket::where('statut','archive')
                  ->whereIn('comptoir_id', $comptoirids)
                  ->whereBetween('date_operation', [$periode_min, Carbon::parse($periode_max)->endOfDay()])
                  ->get();
            if(!$tickets->isEmpty()){
                  return $tickets;
            }else{
                  return collect();
            }
      }

      public static function getTicketEnCoursByComptoir($caisse, $periode_min, $periode_max){
            $comptoirids = $caisse->comptoirs->map(function($item){
                  return $item->id;
            });
            $tickets = Ticket::where('statut','en cours')
                  ->whereIn('comptoir_id', $comptoirids)
                  ->whereBetween('date_operation', [$periode_min, Carbon::parse($periode_max)->endOfDay()])
                  ->get();
            if(!$tickets->isEmpty()){
                  return $tickets;
            }else{
                  return collect();
            }
      }
}