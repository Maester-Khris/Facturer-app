<?php

namespace App\Traits;
use App\Models\Personnel;

trait PersonnelTrait {
      public static function getEmployeeByMatricule($matricule){
            $personnel = Personnel::where('matricule',$matricule)->first();
            return  $personnel;
      }
}