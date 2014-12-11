<?php

namespace Stevebauman\Maintenance\Viewers;

class EventViewer extends BaseViewer {
    
    /**
     * Returns a view of the profile of the event
     * 
     * @return view
     */
    public function profile()
    {
        return view('maintenance::viewers.events.profile', array(
            'event' => $this->entity,
        ));
    }
    
    /**
     * Presents the correct date timestamp depending if the event is all day
     * 
     * @return string
     */
    public function startFormatted()
    {
        $start = new \DateTime();
        
        $start->setTimestamp(strtotime($this->entity->start));
        
        if($this->entity->all_day) {
            return $start->format('M dS Y'); 
        } else {
            return $start->format('M dS Y - h:ia'); 
        }
    }
    
    /**
     * Presents the correct start date formatted for editing
     * 
     * @return string
     */
    public function startDateFormatted()
    {
        $start = new \DateTime();
        
        $start->setTimestamp(strtotime($this->entity->start));
        
        return $start->format('m/d/Y'); 
    }
    
    /**
     * Presents the correct start time formatted for editing
     * 
     * @return type
     */
    public function startTimeFormatted()
    {
        if(!$this->entity->all_day) {
            $start = new \DateTime();
        
            $start->setTimestamp(strtotime($this->entity->start));

            return $start->format('H:i A'); 
        }
    }
    
    /**
     * Presents the correct date timestamp depending if the event is all day
     * 
     * @return string
     */
    public function endFormatted()
    {
        $end = new \DateTime();
        
        $end->setTimestamp(strtotime($this->entity->end));
        
        if($this->entity->all_day) {
            return $end->format('M dS Y'); 
        } else {
            return $end->format('M dS Y - h:ia'); 
        }
    }
    
    /**
     * Presents the correct end date formatted for editing
     * 
     * @return string
     */
    public function endDateFormatted()
    {
        $end = new \DateTime();
        
        $end->setTimestamp(strtotime($this->entity->start));
        
        return $end->format('m/d/Y'); 
    }
    
    /**
     * Presents the correct end time formatted for editing
     * 
     * @return string
     */
    public function endTimeFormatted()
    {
        if(!$this->entity->all_day) {
            $end = new \DateTime();
            
            $end->setTimestamp(strtotime($this->entity->start));

            return $end->format('H:i A'); 
        }
    }
    
    /**
     * Returns a view of the all day label
     * 
     * @return type
     */
    public function lblAllDay()
    {
        return view('maintenance::viewers.events.labels.all-day', array('event'=>$this->entity));
    }
    
    /**
     * Returns a view of the action buttons for display on the index of all events
     * attached to an asset
     * 
     * @param object $asset
     * @return view
     */
    public function btnActionsForAsset($asset)
    {
        return view('maintenance::viewers.events.buttons.actions-for-asset', array(
            'event' => $this->entity,
            'asset' => $asset,
        ));
    }
    
}