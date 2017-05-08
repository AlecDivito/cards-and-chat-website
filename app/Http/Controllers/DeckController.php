<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class DeckController extends Controller
{
    /**
     * return a deck freshly bought (in order)
     */
    public function freshDeck(Request $request)
    {
        $client = new Client();
        $deckResponse = $client->get(
            'https://deckofcardsapi.com/api/deck/new'
        );

        return $deckResponse->getBody()->getContents();
    }

    public function freshShuffledDeck(Request $request)
    {
        $this->validate($request, [
            'deck_count' => 'required|max:6|min:1'
        ]);

        $client = new Client();
        $deckResponse = $client->get(
            'https://deckofcardsapi.com/api/deck/new/shuffle',
            [
                'query' => [
                    'deck_count' => $request['deck_count']
                ]
            ]
        );

        return $deckResponse->getBody()->getContents();
    }

    public function reShuffle(Request $request)
    {
        $this->validate($request, [
            "deck_id" =>   'required|alpha_num',
        ]);

        $client = new Client();
        $deckResponse = $client->get(
            "https://deckofcardsapi.com/api/deck/{$request['deck_id']}/shuffle/"
        );

        return $deckResponse->getBody()->getContents();
    }

    public function draw(Request $request)
    {
        $this->validate($request, [
            "deck_id" => 'required|alpha_num',
            "count" =>   'required|min:1|max:52|numeric'
        ]);

        // TIP: replace <<deck_id>> with "new" to create a shuffled deck and draw cards from that deck in the same request.
        $client = new Client();
        $deckResponse = $client->get(
            "https://deckofcardsapi.com/api/deck/{$request['deck_id']}/draw",
            [
                'query' => [
                    'count' => $request['count']
                ]
            ]
        );

        return $deckResponse->getBody()->getContents();
    }

    /**
     * Works only if you are only using 1 deck
     */
    public function discard(Request $request)
    {
        $this->validate($request, [
            "deck_id" =>   'required|alpha_num',
            "pile_name" => 'required|string',
            "cards" =>     'required|string|array',
        ]);

        $client = new Client();
        $deckResponse = $client->get(
            "https://deckofcardsapi.com/api/deck/{$request['deck_id']}/pile/{$request['pile_name']}/add/",
            [
                'query' => [
                    'cards' => $request['cards']
                ]
            ]
        );

        return $deckResponse->getBody()->getContents();
    }

    public function drawFromDiscard(Request $request)
    {
        $this->validate($request, [
            "deck_id" =>   'required|alpha_num',
            "pile_name" => 'required|string',
            "cards" =>     'string',
            "count" =>     'numeric',
        ]);

        if (is_null($request['cards']))
        {
            $query['count'] = $request['count'];
        } else {
            $query['cards'] = $request['cards'];
        }

        $client = new Client();
        $deckResponse = $client->get(
            "https://deckofcardsapi.com/api/deck/{$request['deck_id']}/pile/{$request['pile_name']}/draw/",
            [
                'query' => [
                    $query
                ]
            ]
        );

        return $deckResponse->getBody()->getContents();
    }

}
