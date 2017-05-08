import Errors from './Errors';

class Deck {

    /**
     * Create a new Deck instance
     *
     * @param deckCount
     */
    constructor() {
        this.deckInfo = {};
        this.hand     = [];
        this.pile     = [];

        this.errors = new Errors();
    }

    /**
     * Create a new Fresh Deck (cards are in order)
     *
     * @returns {Promise}
     */
    fresh() {
        return this.requestAction('/api/games/deck/fresh');
    }

    /**
     * Create a Shuffled Deck
     *
     * @param deckCount
     * @returns {Promise}
     */
    shuffled(deck_count = 1) {
        if (deck_count > 6) deck_count = 6;
        else if (deck_count < 1) deck_count = 1;

        return this.requestAction('/api/games/deck/shuffled', {deck_count:deck_count});
    }

    /**
     * Reshuffle the deck
     *
     * @returns {Promise}
     */
    reshuffle() {
        this.hand = [];
        return this.requestAction('/api/games/deck/reshuffle', {deck_id:this.deckInfo['deck_id']});
    }

    /**
     * Draw cards from the deck, and create a new deck if you want
     *
     * @param count
     * @param isNew
     * @param deck_count
     * @returns {Promise}
     */
    draw(count = 1, isNew = false, deck_count = 1) {
        var data = {count:count, deck_id:this.deckInfo['deck_id']};
        if (isNew) {
            data['deck_count'] = deck_count;
            data['deck_id'] = 'new';
            return this.requestAction('/api/games/deck/draw', data);
        } else {
            return this.requestAction('/api/games/deck/draw',data);
        }
    }

    /**
     * Discard cards from your hand into a named pile
     *
     * @param cardArray
     * @param discardPile
     * @returns {Promise}
     */
    discard(cardArray, discardPile = 'discard') {
        var data = {deck_id:this.deckInfo, pile_name:discardPile};
        data['cards'] = cardArray.join();

        var promise = this.requestAction('/api/games/deck/discard', data);

        // After the request is send check for errors, if theres none discard the cards
        if (this.errors.length === 0) {
            this.hand.forEach(function (card, index, object) {
                if (cardArray.contains(card.code)) {
                    object.splice(index, 1);
                }
            });
        }

        return promise;
    }

    /**
     * Draw certian cards from the cards array or draw from the discarded pile stack
     *
     * @param count
     * @param discardPile
     * @param cardArray
     * @returns {Promise}
     */
    discardDraw(count = 1, discardPile = 'discard', cardArray = null) {
        var data = {deck_id:this.deckInfo, pile_name:discardPile};
        if (cardArray == null) {
            data['count'] = count;
        } else {
            data['cards'] = cardArray.join();
        }
        return this.requestAction('/api/games/deck/discarddraw');
    }

    getRemaining() {
        return this.deckInfo['remaining'];
    }

    /**
     * get the users current hand
     *
     * @returns {Array}
     */
    getHand() {
        return this.hand;
    }

    getCard(index) {
        return this.hand[index];
    }

    /**
     * Get the pile array
     *
     * @param pileName
     * @returns {Array}
     */
    getPileRemaining(pileName) {
        return this.pile['pileName'];
    }

    /**
     * Request an action to be made on the deck
     *
     * @param url
     * @returns {Promise}
     */
    requestAction(url, data = null) {
        return new Promise((resolve, reject) => {
            axios.post(url, data)
                .then(response => {
                    this.onSuccess(response.data);

                    resolve(response.data);
                })
                .catch(error => {
                    this.onFail(error.data);

                    reject(error.data);
                });
        });
    }


    /**
     * Handle a successful deck request.
     *
     * @param {object} data
     */
    onSuccess(data) {
        if (data.success) {
            // if the request was successful then take down the overall deck data
            this.deckInfo['deck_id']   = data['deck_id'];
            this.deckInfo['remaining'] = data['remaining'];
            // if a piles key exists, add it to the piles array
            if (data.hasOwnProperty('piles')) {
                for(var dataPile of data.piles) {
                    this.pile[dataPile.key] = dataPile;
                }
            }
            // if cards key exists, add the cards to the users hand
            if (data.hasOwnProperty('cards')) {
                for(var dataCards of data.cards) {
                    this.hand.push(dataCards);
                }
            }
        } else {
            this.onFail(data.error);
        }
    }


    /**
     * Handle a failed deck request.
     *
     * @param {object} errors
     */
    onFail(errors) {
        this.errors.record(errors);
    }

}

/**
 * Card json object
 *
 *     "code": "0D",
       "image": "http://deckofcardsapi.com/static/img/0D.png",
       "suit": "DIAMONDS",
       "value": "10",
       "images": {
                 "png": "http://deckofcardsapi.com/static/img/0D.png",
                 "svg": "http://deckofcardsapi.com/static/img/0D.svg"
       }
 */
export default Deck;