<?php

namespace Milax\Mconsole\Core\API;

use Milax\Mconsole\Contracts\API\ModelAPI;
use Milax\Mconsole\Models\Notification;

class Notifications extends ModelAPI
{
    /**
     * Push notification
     * 
     * @param  string $title [Notification title]
     * @param  string $text  [Notification text]
     * @return mixed
     */
    public function push($title, $text)
    {
        return $this->store([
            'title' => $title,
            'text' => $text,
        ]);
    }
    
    /**
     * Mark notification as seen
     * 
     * @param  int $id [Message id]
     * @return mixed
     */
    public function seen($id)
    {
        $this->update($id, ['seen' => true]);
    }
    
    /**
     * Get unread notifications
     * @return Collection
     */
    public function index()
    {
        $model = $this->model;
        return $model::where('seen', false)->get();
    }
}
