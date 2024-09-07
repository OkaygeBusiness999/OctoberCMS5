<?php namespace Acme\Jarvis\Models;

use Model;
use RainLab\User\Models\User;

class Conversation extends Model
{
    protected $table = 'acme_jarvis_conversations';

    protected $fillable = ['user_id', 'message', 'response'];

    public $belongsTo = [
        'user' => [User::class],
    ];
}
