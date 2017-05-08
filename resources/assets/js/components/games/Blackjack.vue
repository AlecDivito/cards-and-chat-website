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

        <div class="column">
            Close Betting and <button class="button is-primary" @click="beginGame">Begin the Game</button>
        </div>

        <div class="column tabs" >
            Username, Your Cards Are (and that is a total of <span v-text="handTotal"></span>):
            <ul>
                <li v-for="card in hand"
                    :key="hand.id">
                    <img :src="card.image" alt="playing card" height="100px" width="50px">
                    <p><span v-text="card.value"></span> of <span v-text="card.suit"></span></p>
                </li>
            </ul>
        </div>

        <div class="column" v-if=" ! gameDone">
            <button class="button is-primary" @click="hitMe">Hit Yourself</button>
            <button class="button is-warning" @click="stay">Stay</button>
        </div>

        <div class="column">
            <p class="h1" v-text="endGameText"></p>
            <p>Your current money total is <span v-text="totalWon"></span></p>
            <p v-if="gameDone"><button class="button" @click="reset()">Reset Game</button></p>
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
                totalWon: 0,

                handTotal: 0,

                gameDone: false,

                endGameText: '',

                deck: new Deck(),
                hand: [],
            }
        },
        created() {
            this.deck.shuffled(6);
        },
        methods: {
            betMoney() {
                this.totalBet += this.bet;
                this.bet = 0;
            },
            beginGame() {
                this.bettingOpen = false;
                this.deck.draw(2)
                    .then(response => {
                        this.hand = this.deck.getHand();
                        this.doesWin();
                    });
            },
            hitMe() {
                this.deck.draw(1)
                    .then(response => {
                        this.hand = this.deck.getHand();
                        this.doesWin();
                    });
            },
            doesWin() {
                var aceCounter = 0;
                this.handTotal = 0;
                for(var i = 0; i < this.hand.length; i++) {
                    if (this.hand[i].value === 'KING' || this.hand[i].value === 'QUEEN' || this.hand[i].value === 'JACK' ) {
                        this.handTotal += 10;
                    } else if(this.hand[i].value === 'ACE') {
                        aceCounter++;
                    } else {
                        this.handTotal += parseInt(this.hand[i].value);
                    }
                }
                for(var i = 0; i < aceCounter; i++) {
                    if ((this.handTotal + 11) > 21) {
                        this.handTotal += 1;
                    } else {
                        this.handTotal += 11;
                    }
                }
                if (this.handTotal === 21) {
                    this.win();
                } else if(this.handTotal > 21) {
                    this.bust();
                }
            },
            stay() {
                if (this.handTotal === 21 || this.handTotal >= 18) {
                    this.win();
                } else if(this.handTotal > 21) {
                    this.bust();
                }
            },
            win() {
                // move total bet into total won
                this.endGameText = 'Congratz you won. Take your ' + this.totalBet * 2;
                this.totalWon += this.totalBet * 2;
                this.endGame();
            },
            bust() {
                // remove total bet from total won
                this.endGameText = 'Sorry, you lost.';
                this.totalWon -= this.totalBet;
                this.endGame();
            },
            endGame() {
                // maybe do something here idk
                // this.reset();
                this.gameDone = true;
            },
            reset() {
                this.deck.reshuffle()
                    .then(response => {
                        this.hand = [];
                        this.bet = 0;
                        this.totalBet = 0;
                        this.handTotal = 0;
                        this.bettingOpen = true;
                        this.gameDone = false;
                        this.endGameText = '';
                    });
            }
        }
    }
</script>