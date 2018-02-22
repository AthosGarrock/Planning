 <?php

class Calendar {  
    /**
     * Constructor
     */
    public function __construct($data){     
        // $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
        $this->_themes = $data;
        $this->_wm = new WeekManager();
        $this->_em = new EntryManager();
    }

    public function __toString(){

        //Utiliser try/catch permet d'afficher un message d'erreur dans la méthode __toString.

        try {
           return $this->show();
        } catch ( Exception $e ) {
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
        
    }
     
    /********************* PROPERTY ********************/  
    private $dayLabels = ["Lu","Ma","Me","Je","Ve","Sa","Di"];
    private $currentYear = 0;   
    private $currentMonth = 0;    
    private $currentDay = 0;   
    private $currentDate = null; 
    private $daysInMonth = 0;  
    private $naviHref = null;
    private $_themes; 
    private $_wm; #WeekManager
    private $_em; #entryManager

    /********************* PRIVATE **********************/ 
    /**
    * print out the calendar
    */
    private function show(){

        // var_dump($this->_themes);

        $year = !empty($_GET['year'])?$_GET['year']:date('Y');      
        $month = !empty($_GET['month'])?$_GET['month']:date('m');
                     
        $this->currentYear = $year;
        $this->currentMonth = $month;
         
        $this->daysInMonth  = $this->_daysInMonth($month,$year);  
         
        $content='<div id="calendar">
                        <div class="box">'.
                        $this->_createNavi().
                        '</div>'.
                        '<div class="box-content">'.
                                '<ul class="label">'.$this->_createLabels().'</ul>
                                <div class="clear"></div>
                                <ul class="dates">';   
                                 
                                $weeksInMonth = $this->_weeksInMonth($month,$year);
                                // Create weeks in a month
                                for( $i=0; $i<$weeksInMonth; $i++ ){                              
                                    //Create days in a week
                                    for($j=1;$j<=7;$j++){
                                        $content.=$this->_showDay($i*7+$j);
                                    }
                                }
                                 
        $content.=              '</ul>
                                <div class="clear"></div>
                        </div>
                </div>'; 

        return $content; 
    }

    /**
    * create the li element for ul - the cells of the planing.
    */
    private function _showDay($cellNumber){
        if($this->currentDay == 0){      
            $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));
                     
            if(intval($cellNumber) == intval($firstDayOfTheWeek)){
                $this->currentDay=1;
            }
        }
         
        if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){
            $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));
             
            $cellContent = $this->currentDay;
             
            $this->currentDay++;   
             
        }else{
            $this->currentDate = null;
 
            $cellContent = null;
        }

        //CLASSES  AND ATTRIBUTES OF THE DAY
            $day_pos = ($cellNumber % 7 == 1)? 'start': ( ($cellNumber % 7 == 0)?'end ':null);
            $is_null = ($cellContent==null?' mask ':null);
            $is_today = ($this->currentDate==date('Y-m-d')?' today':null);

            //Récupère les informations liées au jour.
            $class_theme = null;
            $d_id = null;

            if (!empty($this->_themes)) {
                foreach ($this->_themes as $value) {
                    $start = new DateTime($value['d_start']);
                    $end = new DateTime($value['d_end']);
                    $cur = !empty($this->currentDate)?new DateTime($this->currentDate):null;      
                    $cur_day = lcfirst(date('D',strtotime($this->currentDate))); #date en jour (mon, tue...)
                   
                   //Si le jour est bien compris dans une période entrée...
                    if ( $start <= $cur AND $end >= $cur) {
                        //Checke si il y a précision de durée ou non.
                        $week = $this->_wm->get($value['id']);
                        if (!empty($week)) {
                            if ($week[$cur_day]) {
                                $class_theme = ' '.$value['theme'];
                            }
                        } else{
                            $class_theme = ' '.$value['theme'];
                        }     
                    } 
                    if ($start == $cur) {
                        $th_display = $value['theme'];

                        $d_id = $value['id'];

                        
                    }
                }
            }


            $classes = $day_pos.$is_null.$is_today.$class_theme;
                    
        return '<li id="li-'.$this->currentDate.'" class="'.$classes.'"'. 
                    //Attributes
                    (!empty($class_theme)?' theme="'.$class_theme.'"':'').
                    (!empty($d_id)?'entry="'.$d_id.'"':'').
                '>'.$cellContent.'<div class="desc">'.(!empty($th_display)?$th_display:null).'</div></li>';

    }
     
    /**
    * create navigation
    */
    private function _createNavi(){
         
        $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;   
        $nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;  
        $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1; 
        $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;

        return
            '<div class="header">'.
                '<a class="prev" href="'.ROOT.'/index.php?month='.sprintf('%02d',$preMonth).'&year='.$preYear.'">&#10229;</a>'.
                    '<span class="title">'.date('m/Y',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')).'</span>'.
                '<a class="next" href="'.ROOT.'/index.php?month='.sprintf("%02d", $nextMonth).'&year='.$nextYear.'">&#10230;</a>'.
            '</div>';
    }
         
    /**
    * create calendar week labels
    */
    private function _createLabels(){         
        $content='';
         
        foreach($this->dayLabels as $index => $label){
             
            $content.='<li class="'.($label==6?'end title':'start title').' title">'.$label.'</li>';
 
        }
         
        return $content;
    }
     
     
     
    /**
    * calculate number of weeks in a particular month
    */
    private function _weeksInMonth($month=null,$year=null){
         
        if( empty($year) ) {
            $year = date("Y"); 
        }
         
        if( empty($month) ) {
            $month = date("m");
        }
         
        // find number of days in this month
        $daysInMonths = $this->_daysInMonth($month,$year);
         
        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
         
        $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
         
        $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
         
        if($monthEndingDay<$monthStartDay){   
            $numOfweeks++; 
        }
         
        return $numOfweeks;
    }
 
    /**
    * calculate number of days in a particular month
    */
    private function _daysInMonth($month=null,$year=null){       
        if(null==($year))
            $year = date("Y"); 
 
        if(null==($month))
            $month = date("m");
             
        return date('t',strtotime($year.'-'.$month.'-01'));
    }
}
