<template>
    <div class="container">

        <div class="columns is-modile" v-if="bettingOpen">
            <div class="column is-half is-offset-one-quarter">
                <div class="box">
                    <div class="field has-addons has-addons-centered">
                        <p class="control">
                            <span class="select">
                              <select>
                                <option>$</option>
                              </select>
                            </span>
                        </p>
                        <p class="control">
                            <input class="input" v-model.number="bet" type="number" placeholder="Amount of money">
                        </p>
                        <p class="control">
                            <a class="button is-primary" @click="betMoney">
                                Bet
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <div class="column">
            You Bet: <span v-text="totalBet">0.00</span>
        </div>

        <div class="column" v-if="isGameNotActive">
            Close Betting and <button class="button is-primary" @click="beginGame">Begin the Game</button>
        </div>

        <div class="column">
            <div class="box">
                <div class="columns">
                    <div class="column has-text-centered">
                        <header>
                            <p>Player 1 (<span v-text="player1Cards.length"></span>)</p>
                        </header>
                        <ul>
                            <li v-if="hasWarStarted" v-for="card in player1ActiveCards" :key="player1ActiveCards.id">
                                <img :src="card.image" alt="playing card" height="100px" width="50px">
                                <p><span v-text="card.value"></span> of <span v-text="card.suit"></span></p>
                            </li>
                        </ul>
                    </div>
                    <div class="column has-text-centered">
                        <button class="button" v-if=" ! isBattleDone" @click="warRound()">WAR</button>
                        <button class="button" v-if="isBattleDone"    @click="clearBoard()">Clear War</button>
                        <p v-text="reason"></p>
                    </div>
                    <div class="column has-text-centered">
                        <header>
                            <p>Player 2 (<span v-text="player2Cards.length"></span>)</p>
                        </header>
                        <ul>
                            <li v-if="hasWarStarted" v-for="card in player2ActiveCards" :key="player2ActiveCards.id">
                                <img :src="card.image" alt="playing card" height="100px" width="50px">
                                <p><span v-text="card.value"></span> of <span v-text="card.suit"></span></p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
    import Deck from '../../util/Deck';

    export default {
        data() {
            return {
                bettingOpen: true,
                bet: 0,
                totalBet: 0,

                // board
                hasWarStarted: false,
                isGameNotActive: true,
                isBattleDone: false,
                reason: '',

                deck: new Deck(),
                // Some of the game data needed to store the piles
                // player 1 piles
                player1Cards: [],
                player1ActiveCards: [],
                // player 2 piles
                player2Cards: [],
                player2ActiveCards: [],

            }
        },
        methods: {
            betMoney() {
                this.totalBet += this.bet;
                this.bet = 0;
            },
            beginGame() {
                this.bettingOpen = false;
                this.isGameNotActive = false;
                this.deck.shuffled(1)
                    .then(response => {
                        this.setupGame();
                    })
                    .catch(error => {
                        console.log(error.data);
                    });
            },
            setupGame() {
                this.deck.draw(52)
                    .then(response => {
                        for(var i = 0; i < this.deck.getHand().length; i) {
                            this.player1Cards.push(this.deck.getCard(i++));
                            this.player2Cards.push(this.deck.getCard(i++));
                        }
                        this.hasWarStarted = true;
                    })
                    .catch(error => {
                        console.log(error.data);
                    });
            },
            warRound() {
                if (this.hasWarStarted) {
                    // get the top object from the players decks
                    var player1Card = this.player1Cards.pop();
                    var player2Card = this.player2Cards.pop();
                    // push them on to the active decks
                    this.player1ActiveCards.push(player1Card);
                    this.player2ActiveCards.push(player2Card);
                    // evaluate the cards into numbers to check them
                    var player1CardValue = this.evaluateCardValue(player1Card.value);
                    var player2CardValue = this.evaluateCardValue(player2Card.value);
                    // decide who won the battle
                    this.decideWinner(player1CardValue, player2CardValue);
                    // check to see if anyone has lost the war
                    this.checkWarStatus();
                    // the battle is now done, everything is were it should be. notify the user to clear the board
                    this.isBattleDone = true;
                }
            },
            evaluateCardValue(cardValue) {
                if (cardValue === 'ACE')
                    return 14;
                else if (cardValue === 'KING')
                    return 13;
                else if (cardValue === 'QUEEN')
                    return 12;
                else if (cardValue === 'JACK')
                    return 11;
                else {
                    return parseInt(cardValue);
                }
            },
            decideWinner(player1CardValue, player2CardValue) {
                // both cards are the same, each player plays all or 3 cards from there deck
                if (player1CardValue === player2CardValue) { // war again
                    this.drawThree();
                    this.warRound();
                    return;
                }

                // join the 2 active piles to together
                var cardPot = this.player1ActiveCards.concat(this.player2ActiveCards);
                cardPot = this.shuffle(cardPot);
                // There was no war, so check who won and add the pot to the bottom of the winning players deck
                if(player1CardValue > player2CardValue)
                {   // player one win
                    this.player1Cards = cardPot.concat(this.player1Cards);
                    this.reason = 'player 1 won';
                }
                else if(player2CardValue > player1CardValue)
                {   // player two win
                    this.player2Cards = cardPot.concat(this.player2Cards);
                    this.reason = 'player 2 won';
                }
            },
            drawThree() {
                if (this.player1Cards.length <= 1 || this.player2Cards.length <= 1) {
                    if (this.player1Cards.length <= 1) {
                        this.endGame('Player 1', "(s)he did not have enough cards to get through the battle");
                    } else {
                        this.endGame('Player 2', "(s)he did not have enough cards to get through the battle");
                    }
                }
                // - 2 because when we redeal for war, they need at least on card
                for (var i = 0; i < this.player1Cards.length - 2; i++) {
                    this.player1ActiveCards.push(this.player1Cards.pop());
                    if (i === 2) break;
                }
                for (var i = 0; i < this.player2Cards.length - 2; i++) {
                    this.player2ActiveCards.push(this.player2Cards.pop());
                    if (i === 2) break;
                }
            },
            checkWarStatus() {
                if (this.player1Cards.length === 0) {
                    this.endGame('Player 1', "(s)he lost all there cards");
                } else if ( this.player2Cards.length === 0) {
                    this.endGame('Player 2', "(s)he lost all there cards");
                }
            },
            endGame(player, reason) {
                this.reason = player + ' lost because ' + reason;
            },
            clearBoard() {
                this.player1ActiveCards = [];
                this.player2ActiveCards = [];
                this.isBattleDone = false;
            },
            /**
             * Shuffles array in place. ES6 version
             * @param {Array} a items The array containing the items.
             */
            shuffle(array) {
                for (let i = array.length; i; i--) {
                    let j = Math.floor(Math.random() * i);
                    [array[i - 1], array[j]] = [array[j], array[i - 1]];
                }
                return array;
            }

        }
    }
</script>