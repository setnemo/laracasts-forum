<?php


namespace App;


trait RecordsActivity
{
    /**
     *
     */
    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) {
            return;
        }

        foreach (static::getActivitiesRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }
    }

    /**
     * @return array
     */
    protected static function getActivitiesRecord()
    {
        return ['created', 'deleted'];
    }

    /**
     * @param $event
     * @throws \ReflectionException
     */
    protected function recordActivity($event)
    {
        $this->activity()->create([
            'type' => $this->getActyvityType($event),
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * @return mixed
     */
    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }

    /**
     * @param $event
     * @return string
     * @throws \ReflectionException
     */
    protected function getActyvityType($event): string
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());

        return "{$event}_{$type}";
    }
}
