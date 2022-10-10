<section class = "storepage">
   <div class="main" onclick="load_game(<?=$collection[0][1]?>)">
      <img class="poster" src=<?=$collection[0][2]?>>
      <div class="bottom-left"><?= $collection[0][0]?></div>
      <div class="top-right"><?= $collection[0][3]?></div>
   </div>

   <div class="main" onclick="load_game(<?=$collection[1][1]?>)">
      <img class="poster" src=<?=$collection[1][2]?>>
      <div class="top-left"><?= $collection[1][3]?></div>
      <div class="bottom-right"><?= $collection[1][0]?></div>
   </div>

   <section class="wrapper" onclick="load_game(<?=$collection[2][1]?>)">
      <article class="flex-item1">
         <img class="poster" src=<?=$collection[2][2]?>>
      </article>
      <article class="flex-item">
         <h1 class="name"> <?= $collection[2][0] ?></h1>
         <h1 class="descript"><?= $collection[2][3] ?></h1>
      </article>
   </section>

   <section class="wrapper" onclick="load_game(<?=$collection[3][1]?>)">
      <article class="flex-item1">
         <img class="poster" src=<?=$collection[3][2]?>>
      </article>
      <article class="flex-item">
         <h1 class="name"> <?= $collection[3][0] ?></h1>
         <h1 class="descript"><?= $collection[3][3] ?></h1>
      </article>
   </section>

   <section class="wrapper" onclick="load_game(<?=$collection[4][1]?>)">
      <article class="flex-item1">
         <img class="poster" src=<?=$collection[4][2]?>>
      </article>
      <article class="flex-item">
         <h1 class="name"> <?= $collection[4][0] ?></h1>
         <h1 class="descript"><?= $collection[4][3] ?></h1>
      </article>
   </section>
</html>

<style>

.wrapper {
   width: 90%;
   align:center;
   margin: 5%;
}

.wrapper img {
   width: 80%;
}

.main {
  position: relative;
  text-align: center;
  color: white;
}

.main img {
   width: 65vw;
}

.bottom-left {
   padding:1vw;
   position: absolute;
   bottom: 2vw;
   left: 20vw;
   background-color: rgba(0, 0, 0, .75);
   max-width: 20vw;
}

.top-left {
   padding:1vw;
   position: absolute;
   top: 2vw;
   left: 20vw;
   background-color: rgba(0, 0, 0, .75);
   max-width: 20vw;``
}

.top-right {
   padding:1vw;
   position: absolute;
   top: 2vw;
   right: 20vw;
   background-color: rgba(0, 0, 0, .75);
   max-width: 20vw;
}

.bottom-right {
   padding:1vw;
   position: absolute;
   bottom: 2vw;
   right: 20vw; 
   background-color: rgba(0, 0, 0, .75);
   max-width: 20vw;
}

</style>