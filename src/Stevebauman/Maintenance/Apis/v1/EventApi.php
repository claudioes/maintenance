<?php

namespace Stevebauman\Maintenance\Apis\v1;

use Stevebauman\Maintenance\Exceptions\RecordNotFoundException;
use Stevebauman\Maintenance\Services\Event\EventService;
use Stevebauman\Maintenance\Apis\v1\BaseApi;

/**
 * API for FullCalendar interactions
 */
class EventApi extends BaseApi
{

    public function __construct(EventService $event)
    {
        $this->event = $event;
    }

    public function index()
    {
        $data = array(
            'timeMin' => strToRfc3339($this->input('start')),
            'timeMax' => strToRfc3339($this->input('end')),
        );

        $events = $this->event->parseEvents($this->event->setInput($data)->getApiEvents());

        return $this->responseJson($events);
    }

    public function create()
    {
        return $this->responseJson(
            view('maintenance::apis.calendar.events.create')->render()
        );
    }

    public function store()
    {

    }

    public function show($id)
    {
        try {
            $event = $this->event->find($id);

            return $this->responseJson(
                view('maintenance::apis.calendar.events.show', array('event' => $event))->render()
            );

        } catch (RecordNotFoundException $e) {
            return NULL;
        }
    }

    public function edit($id)
    {

    }

    public function update($id)
    {
        try {

            $this->event->setInput($this->inputAll())->updateDates($id);

            return $this->responseJson(array(
                'message' => 'Successfully updated event',
                'messageType' => 'success',
            ));

        } catch (RecordNotFoundException $ex) {
            return NULL;
        }
    }

    public function destroy($id)
    {

    }

}