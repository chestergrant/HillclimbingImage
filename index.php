<!DOCTYPE html>
<html>
<head>
<script type="text/javascript">
var c;
var ctx;
var population_size = 50;
var population;
var img_width;
var img_height;
var target;
var mutation_rate = 0.001;
var pop_fitness =  new Array();
var best_fitness = 1000000000;
var best_idx = 0;
var generation = 0;
var interval_id;
var best;

window.addEventListener('load', function () {
              
              function init(){
                  c=document.getElementById("myCanvas");
                  ctx=c.getContext("2d");
                  
                  var img = new Image();
                  img.src = 'image.jpg';
                  img.onload = function(){
                    ctx.drawImage(img, 1, 1);
                    img_width = img.width;
                    img_height = img.height;
                    target = ctx.getImageData(1,1,img_width,img_height);
                     var size = ctx.getImageData(1,1,img.width,img.height).data.length;
                     create_pop(size);                    
                  }
                 
              }
              function random_individual(gene_size){
                  var x = new Uint8ClampedArray(gene_size);
                  
                  for(var i = 0; i< x.length; i++){
                      x[i] = Math.round(Math.random()*255);
                  }
                  
                  return x;
              }
              function create_pop(gene_size){
                  population = new Array();
                  for(var i =0; i < population_size; i++){
                      population[i] = random_individual(gene_size);
                      
                  }
                  best = new Uint8ClampedArray(gene_size);
                  for(var i = 0; i < population[0].length; i++){
                        best[i] = population[0][i];
                  }
              }
              
               init();
            }, false);   
function fitness(x){
    var score = 0;
    for(var i = 0; i < target.data.length; i++){
        score += Math.abs(target.data[i] - x[i]);
    }
    return score;
}
function mutation(){
    var gene_size = population[0].length;
	for(var j = 0; j < population.length; j++){
	    var y = Math.round(Math.random()*(gene_size-1));
		population[j][y] = Math.round(Math.random()*255);   
	}
}




function generate(){
    mutation();
	for(var i =0; i < population.length; i++){
		f = fitness(population[i]);
		if (f < best_fitness){
			best_fitness = f
			for(var j = 0; j < population[0].length; j++){
				best[j] = population[i][j];
			}
		}
    }
	for(var i =0; i < population.length; i++){
		for(var j = 0; j < population[0].length; j++){
				population[i][j] = best[j];
		}
	}
            
    show(); 
    generation++;
    if(best_fitness <= 0){
        clearInterval(interval_id);
    }
    ctx.fillStyle="#FFFFFF";
    ctx.fillRect(200,1,900,50);
    ctx.fillStyle="#000000";
    ctx.fillText("Generation: "+generation,200,10);
    ctx.fillText("Best Fitness: "+best_fitness,200,40);
}

function start(){
   interval_id = setInterval('generate();', 10);   
    
}

function show()
{    
    
    var imgData=ctx.getImageData(1,1,img_width,img_height);
    for(var j = 0; j< population_size; j++){
      for(var i = 0; i < population[j].length; i++ ){
        imgData.data[i] = population[j][i];        
      }    
      ctx.putImageData(imgData,(j%10)*(img_width+10)+1,Math.floor(j/10)*(img_height+10)+70);
      
     }
     
}
</script>
</head>
    
<body>

<canvas id="myCanvas" width="900" height="450" style="border:1px solid #d3d3d3;">
Your browser does not support the HTML5 canvas tag.</canvas>

<button onclick="start()">Start</button>

</body>
</html>

