
enchant();

//ノベルシステム全体
Novel =  enchant.Class.create(enchant.Scene,{
		initialize: function() {
			enchant.Scene.call(this);
			this.promptIcon = new Sprite(16,16);
			this.promptIcon.image = game.assets["http://r.jsgames.jp/samples/atlasx/misc/icon0.gif"];
			this.promptIcon.x=100;
			this.promptIcon.y=1000;
			this.promptIcon.frame=16;
			this.screen=null;
			this.addChild(this.promptIcon);
			this.nextFunc =null;
			this.addEventListener('touchend',function(e){
				novel.promptHide();
			});
			this.promptIcon.addEventListener('enterframe',function(e){
				if(game.frame%2==0)this.y = -this.y-100;
			});
		},
		prompt:function(obj,func){
			game.pushScene(this);
			this.nextObj =obj
			this.nextFunc =func;
		},
		promptHide:function(){
			if(this.nextFunc){
				game.popScene();
				var x =this.nextFunc;
				this.nextFunc=null;
				x.call(this.nextObj);
			}
		},
		hide:function(){
			game.popScene();
		},
		jump:function(nextScene,str){
			nextScene.call(this,str);
		},
		next:function(){
			if(this.nextScene){
				this.nextScene.call(this);
			}
		}
	});

//ノベルが表示されるスクリーン
Screen =  enchant.Class.create(enchant.Scene,{
		initialize: function() {
			enchant.Scene.call(this);
			this.image = new Label("");
			this.image.x =10;
			this.image.y =10;
			this.addChild(this.image);
			this.front = new Group();
			this.front.x =0;
			this.front.y =0;
			this.addChild(this.front);
			this.labels = new Array();
			this.queue = new Array();
			this.count=0;
			this.cursor=0;
			this.selectCursor=0;
			this.color="#000000";
		
		},
		show: function(){
			game.popScene();
			game.pushScene(this);
		},
		
		add:function(){
			var arg =new Array();
			for(var i=0;i<arguments.length;i++)
				arg.push(arguments[i]);
			
			var func =arg.shift();
			this.queue.push(function(){ return func.apply(this,arg);});
		},
		waitForPrompt:function(){
			return false;
		},
		setImage:function(file,opt){
			if(opt == undefined)
				opt="width=100%";
			this.image.text = "<img src="+file+" "+opt+" >";
			return true;
		},
		writeLine:function(str,col){
			var label = new Label("");
			if(col == undefined)
				label.text = "<font color="+this.color+">"+str+"<BR>";
			else
				label.text = "<font color="+col+">"+str+"<BR>";
			label.x = 10;
			label.y = 20*this.cursor+10;
			this.addChild(label);
			this.labels.push(label);
			novel.promptIcon.x = 10+str.length*12;
			novel.promptIcon.y = 20*this.cursor+10;
			this.cursor++;
			return true;
		},
		selector:function(){
			var arg =new Array();
			for(var i=0;i<arguments.length;i++)
				arg.push(arguments[i]);
			
			var str =arg.shift();
			var func =arg.shift();
			var selector = new Label("");
			selector.text = str;
			selector._element.setAttribute("class","selector");
			selector.touchEnabled=true;
			selector.x = 5;
			selector.y = 320-33*(this.selectCursor+1);
			this.selectCursor++;
			selector.addEventListener("touchend",function(){
							シーン開始();
							if(typeof arg[2]=='function'){
								arg[2].call(this);
							}else
							if(arg[2]){
								eval(arg[2]);
							}
							func.apply(this,arg);
							シーン終了();});
			this.addChild(selector);
			this.cursor++;
			return true;
		},
		changeColor:function(col){
			this.color =col;
			return true;
		},
		start: function(){
			if(this.count == this.queue.length)return;
			var result;
			while(result= this.queue[this.count++].call(this)){
				if(this.count == this.queue.length)break;
			}
			if(this.count == this.queue.length){
//				novel.prompt(this,this.end);
				return;
			}
			novel.prompt(this,this.start);
		},
		
		progress: function(){
			if( typeof this.scriptBody[this.cursor] == "string"){
				this.label.text += "<font color=white>"+this.scriptBody[this.cursor]+"<BR>";
				novel.promptIcon.x = 10+this.scriptBody[this.cursor].length*12;
				novel.promptIcon.y = 16*this.cursor+10;
				this.cursor++;
				if(this.cursor == this.scriptBody.length){
				//					novel.prompt(this,this.end);
				}else{
					novel.prompt(this,this.progress);
				}
			}else{
				//文字列じゃなかったらコマンド実行
				this.scriptBody[this.cursor].call(null,
									this.scriptBody[this.cursor+1]);
				this.cursor+=2;
			}
		},
		end:function(){
			game.popScene();
		}
	});
	
var screen;
	
シーン開始 =function (){
	novel.screen =new Screen();
	novel.screen.show();
};
台詞 = function(){
	var arg =new Array();
	for(var i=0;i<arguments.length;i++)
				arg.push(arguments[i]);
	novel.screen.queue.push(function(){ return novel.screen.writeLine.apply(this,arg);});
};


画像 = function(file){
	var arg =new Array();
	for(var i=0;i<arguments.length;i++)
				arg.push(arguments[i]);
				novel.screen.queue.push(function(){ return novel.screen.setImage.call(this,file);});
};

キャラ = function(file,x,y){
	var img = new Label("<img src="+file+">");
	novel.screen.queue.push(function(){
			if(x == undefined){
				img.x=100;img.y=100;
			}else{
				img.x=x;img.y=y;
			}
			novel.screen.front.addChild(img);
			return true;
		});
	return img;
};

一時停止 = function(){
	novel.screen.add(novel.screen.waitForPrompt);
};
選択肢 = function(str,jumpTo,option){
	novel.screen.add(novel.screen.selector,str,novel.jump,jumpTo,str,option);
};
次へ = function(jumpTo,option){
	novel.screen.add(novel.screen.selector,"次へ",novel.jump,jumpTo,"次へ",option);
};
シーン終了 = function (){
	novel.screen.start();
}
	
乱数 = function(max){
	return Math.floor(Math.random()*max);
	
}
	
どれか =function(arg){
	return arg[Math.floor(Math.random()*arg.length)];
};

誰か = function(){
	return Math.floor(Math.random()* 友達の名前.length);
}
	
YES = true;
NO = false;
はい =true;
いいえ = false;
そう =true;
まだ =false;


window.onload = function() {
	game = new Game(320, 320);
	game.preload("http://r.jsgames.jp/samples/atlasx/misc/icon0.gif", "logo2.png");
    game.fps = 15;
	game.onload = function() {
		novel = new Novel();
        if(プレイヤー読み込み === true){
            var obj = game.twitterAssets["account/verify_credentials"][0];
            プレイヤー = obj;
            プレイヤーの名前 = obj.name;
            プレイヤーのユーザID = obj.screen_name;
            プレイヤーのアイコン = obj.profile_image_url;
            プレイヤーのフォロワー数 = obj.followers_count;
        }
        if(友達読み込み === true){
            var obj = game.twitterAssets["statuses/friends"];
            友達 = shuffle(obj);
            友達の名前 = [];
            友達のユーザID = [];
            友達のアイコン = [];
            友達のフォロワー = [];
            for(var i in obj){
                game.preload(obj[i].profile_image_url)
                友達の名前.push(obj[i].name);
                友達のユーザID.push(obj[i].screen_name);
                友達のアイコン.push(obj[i].profile_image_url);
                友達のフォロワー.push(obj[i].followers_count);
            }
        }
        
//		game.rootScene.backgroundColor="#000";
		var bg1 = new Sprite(320, 320);
		bg1.image = game.assets["logo2.png"];
		game.rootScene.addChild(bg1);
		シーン開始();
		プロローグ();
		シーン終了();
	};
    
    if(プレイヤー読み込み === true){
        game.twitterRequest("account/verify_credentials");
    }
    
    if(友達読み込み === true){
        game.twitterRequest("statuses/friends");
    }
    
    game.start();
};


/* TwitterAPI */

友達読み込み = function (){
    友達読み込み = true;
}

プレイヤー読み込み = function (){
    プレイヤー読み込み = true;
}


function shuffle(list) {
  var i = list.length;

  while (--i) {
    var j = Math.floor(Math.random() * (i + 1));
    if (i == j) continue;
    var k = list[i];
    list[i] = list[j];
    list[j] = k;
  }

  return list;
}


