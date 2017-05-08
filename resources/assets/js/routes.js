import VueRouter from 'vue-router';

let routes = [
    { path: '/',                 redirect: '/home'},
    { path: '/home',             component: require('./components/Home')},
    { path: '/about',            component: require('./components/About')},
    { path: '/contact',          component: require('./components/Contact')},
    { path: '/test',          component: require('./components/Test')},
    { path: '/login',            component: require('./components/Login')},
    { path: '/register',         component: require('./components/Register')},
    {
        path: '/chatroom',
        name: 'ChatRoom',
        component: require('./components/ChatRoom.vue'),
        children: [
            {
                path: 'create',
                name: 'createRoom',
                component: require('./components/chat/createRoom.vue'),
            },
            {
                path: ':id',
                name: 'room',
                component: require('./components/chat/room.vue'),
            }
        ]
    },

    // Game Routes...
    {
        path: '/games',
        name: 'gameMain',
        component: require('./components/games/GameMain'),
        children: [
            {
                path: 'blackjack',
                name: 'blackjack',
                component: require('./components/games/Blackjack') },
            {
                path: 'war',
                name: 'war',
                component: require('./components/games/War')
            },
            {
                path: 'poker',
                name: 'poker',
                component: require('./components/games/Poker')
            },
            /*   { path: '/game/crazy8',      component: require('./components/games/CrazyEight') },
             { path: '/game/hearts',      component: require('./components/games/Hearts') },*/
            {
                path: 'suggestions',
                name: 'suggestions',
                component: require('./components/games/Suggestions')
            },
            {
                path: 'chat',
                name: 'chat',
                component: require('./components/games/Chat'),
            }
        ]
    },
]

export default new VueRouter({
    routes,

    linkActiveClass:'is-active'
});