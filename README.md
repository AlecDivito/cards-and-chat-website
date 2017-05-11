# cards-and-chat-website
<p>This is just a fun little (but becoming big) cards and chat website I am
creating. I am using vue.js, laravel and bulma.</p>

<p>The whole point is to was to learn how to use vue.js and continue to deepen
my understanding of laravel.Its to create a working API that my website and
others can consume and learn about some of the API's other giant companys offer.
It is also my first time creating a single page application with vue.js routing.
The current hope is to continue working web services. Some of the web services I
would like it integrate into chat are as followed:</p>

<ul>
  <li><a href="https://dev.twitter.com/rest/public">Twitter</a></li>
  <li><a href="https://developers.facebook.com/">FaceBook</a></li>
  <li><a href="https://watson-api-explorer.mybluemix.net/">Watson</a></li>
  <li><a href="https://www.foaas.com/">FOAAS</a></li>
  <li><a href="http://deckofcardsapi.com/">Cards API</a></li>
</ul>

<p>More API's will most likely be added in the future, like a service that allows
the website to accept credit card payments,maybe like paypal to start, so I learn
more about ecommerce and puchases over the web</p>

<h3>How to test out the website</h3>
<ul>
  <li>
    If your using homestead:
    <ul>
      <li>If you don't have homestead
        <a href="https://laravel.com/docs/5.4/homestead">
        follow the following tutorial off laravel</a>
      </li>
      <li>Move or download the repo into your Homestead shared file</li>
      <li>add the domain name <b>cardsandchat.local</b> to the list in your hosts file and
      Homestead.ymal file</li>
      <li>in the root of the homestead file type "vagrent up"</li>
    </ul>
  </li>
  <li>copy the env.example to a new file called ".env"</li>
  <li>start up the server with php of homestead</li>
  <li>cd to the root of the project and type "composer update"</li>
  <li>Then install all javascript packages with: "npm install"</li>
  <li>Then install laravel-echo-server globably: "sudo npm install -g laravel-echo-server"</li>
  <li>Then install laravel passport with "php artisan passport:install"</li>
  <li>create the database inside the .env file inside a mysql database</li>
  <li>Migrate the database with "php artisan migrate"</li>
  <li>start the laravel echo server with "laravel-echo-server start"</li>
  <li>have fun!!</li>
  <li>Note: if your gonna change any javascript I recommend you run
  npm run watch-poll</li>
</ul>

