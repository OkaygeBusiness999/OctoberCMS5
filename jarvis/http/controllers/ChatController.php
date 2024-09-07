<?php namespace Acme\Jarvis\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use RainLab\User\Models\User;
use Acme\Jarvis\Models\Conversation;
use GuzzleHttp\Client;

class ChatController extends Controller
{
    public function handleMessage(Request $request)
    {
        $message = $request->input('message');
        $userId = $request->input('user_id');
        $jarvis = User::where('email', 'jarvis@example.com')->first();

        $conversation = Conversation::create([
            'user_id' => $userId,
            'message' => $message,
        ]);

        $openAiResponse = $this->sendToOpenAi($message);

        $conversation->update(['response' => $openAiResponse]);

        if ($this->isEventCreationIntent($openAiResponse)) {

            [$eventTitle, $eventDate] = $this->extractEventDetails($openAiResponse);

            if (!$eventTitle || !$eventDate) {
                return response()->json([
                    'response' => "Please provide the event name and date."
                ]);
            }

            $calendarResponse = $this->createGoogleEvent($eventTitle, $eventDate, $request->input('google_token'));

            return response()->json(['response' => $calendarResponse]);
        }

        return response()->json(['response' => $openAiResponse]);
    }

    private function sendToOpenAi($message)
    {
        $client = new Client();
        $response = $client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('OPENAI_PROJECT_API_KEY'),
            ],
            'json' => [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                    ['role' => 'user', 'content' => $message],
                ],
                'max_tokens' => 150,
                'temperature' => 0.7,
            ],
        ]);

        return json_decode($response->getBody()->getContents())->choices[0]->text;
    }

    private function isEventCreationIntent($response)
    {
        return strpos($response, 'create event') !== false;
    }

    private function extractEventDetails($response)
    {
        $eventTitle = "Sample Event"; 
        $eventDate = "2024-09-10T10:00:00"; 
        return [$eventTitle, $eventDate];
    }

    private function createGoogleEvent($title, $date, $userAccessToken)
    {
        $client = new \Google\Client();
        $client->setAccessToken($userAccessToken);

        $service = new \Google\Service\Calendar($client);

        $event = new \Google\Service\Calendar\Event([
            'summary' => $title,
            'start' => [
                'dateTime' => $date,
                'timeZone' => 'UTC',
            ],
            'end' => [
                'dateTime' => $date,
                'timeZone' => 'UTC',
            ],
        ]);

        $calendarId = 'primary';
        $service->events->insert($calendarId, $event);

        return "Event '$title' created successfully!";
    }
}
