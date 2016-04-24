<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\ModelAPI;
use Milax\Mconsole\Models\Notification;

class Notifications extends ModelAPI
{
    /**
     * Push notification
     * 
     * @param  string $title [Notification title]
     * @param  string $text  [Notification text]
     * @param  string $link  [Link on click]
     * @param  int $user  [User id]
     * @return mixed
     */
    public function push($title, $text, $link = null, $user = null)
    {
        return $this->store([
            'title' => $title,
            'text' => $text,
            'link' => $link,
            'user_id' => $user,
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
    public function get()
    {
        $model = $this->model;
        return $model::where('seen', false)->where(function ($query) {
            $query->where('user_id', \Auth::id())->orWhere('user_id', 0);
        })->get();
    }
}
