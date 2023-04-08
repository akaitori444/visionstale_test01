function toggleText() {
  let text = document.getElementById("text");
  if (text.style.display === "none") {
    text.style.display = "block";
  } else {
    text.style.display = "none";
  }
}

//HTMLが完全に読み込み終わってからdraw()を実行する
window.onload = function () {
  draw();
};

function draw () {
  let canvas = document.getElementById('mycanvas');
  if (!canvas || !canvas.getContext) return false;
  let ctx = canvas.getContext('2d');

  //ここからctx（Canvasオブジェクト）に対しての描画処理を書く
  ctx.globalAlpha = 0.5;
    let a = new Array('HTML5','CSS','JavaScript','Web','Canvas');

    for (let i = 0; i < 50; i++) {
        let x = Math.floor(Math.random() * 800);
        let y = Math.floor(Math.random() * 600);
        let r = Math.floor(Math.random() * 60);

        ctx.font = "bold "+r+"px Verdana"; // 文字フォント指定
        ctx.fillStyle = "rgb("+rgb()+","+rgb()+","+rgb()+")"; // 塗りつぶしスタイル指定
        ctx.fillText(a[i%5], x, y, 200); // (文字,始点x,y,最大横幅)に文字を描画
        ctx.strokeText('Canvas', x, y, 200); // 縁取り文字を描画
    }

    function rgb () {
        return Math.floor(Math.random() * 255);
    }
  }

