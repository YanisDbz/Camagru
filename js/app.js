const canvas = document.getElementById('cvs');
const combined = document.getElementById('combined');
const filterSelect = document.getElementById('filter');
const btn1 = document.getElementById('btn1');
const btn2 = document.getElementById('btn2');
const vivi = document.getElementById('sourcevid');
document.getElementById('campress').disabled = true;
document.getElementById('campress').onclick = null;


function init() {
    navigator.mediaDevices.getUserMedia({ audio: false, video: { width: 1200, height: 720 } }).then(function(mediaStream) {
        var video = document.getElementById('sourcevid');
        video.srcObject = mediaStream;
        document.getElementById('output').remove();
        document.getElementById('img-file').remove();
        document.getElementById('campress2').remove();
        video.onloadedmetadata = function(e) {
            video.play();
        };
    }).catch(function(err) { 
      console.log(err.name + ": " + err.message);
      document.getElementById('campress').remove();
      document.getElementById('sourcevid').remove();
      document.getElementById('campress2').disabled = true;
      document.getElementById('campress2').onclick = null;
      data[0].style.pointerEvents = 'none';
      data[1].style.pointerEvents = 'none';
    });
}

filterSelect.onchange = function() {
  
  if(document.getElementById('sourcevid'))
  {
    var video_filter = document.getElementById('sourcevid');
    video_filter.className = "img-fluid w-75";
    video_filter.classList.add(filterSelect.value);
  }
  else
  {
    var img_filter = document.getElementById('output');
    img_filter.className = "img-fluid";
    img_filter.classList.add(filterSelect.value);
  }
};

function clone2(){
  var x2 = 0;
  var y2 = 0;
  var img = document.getElementById("output");
  canvas.width = img.offsetWidth;
  canvas.height = img.offsetHeight;
  var canw = img.offsetWidth;
  var canh = img.offsetHeight;
  combined.className = filterSelect.value + " img-camera-can";
  canvas.getContext('2d').drawImage(img, x2, y2, canw, canh);
  imgToCanvas();

  var b64 = document.getElementById('cvs').toDataURL("image/jpeg");
  document.getElementById('tar').value = '';
  document.getElementById('tar').value=b64;
  document.getElementById('ov-left').value=document.getElementById('video_overlays').offsetLeft;
  document.getElementById('ov-top').value=document.getElementById('video_overlays').offsetTop;

  document.getElementById('img_over').value = canvas2.toDataURL("image/png");
  btn1.classList.replace('btn-sub', 'btn-sub-go');
  btn2.classList.replace('btn-sub', 'btn-sub-go');
  combined.getContext('2d').drawImage(canvas, 0, 0);
  combined.getContext('2d').drawImage(canvas2, document.getElementById('video_overlays').offsetLeft, document.getElementById('video_overlays').offsetTop);
}
function clone(){
  var x2 = 0;
  var y2 = 0;
  canvas.width = vivi.offsetWidth;
  canvas.height = vivi.offsetHeight;
  var canw = vivi.offsetWidth;
  var canh = vivi.offsetHeight;
  combined.className = filterSelect.value + " img-camera-can";
  canvas.getContext('2d').drawImage(vivi, x2, y2, canw, canh);
  imgToCanvas();

  var base64=document.getElementById('cvs').toDataURL("image/jpeg");
  document.getElementById('tar').value='';
  document.getElementById('tar').value=base64;
  document.getElementById('ov-left').value=document.getElementById('video_overlays').offsetLeft;
  document.getElementById('ov-top').value=document.getElementById('video_overlays').offsetTop;

  document.getElementById('img_over').value = canvas2.toDataURL("image/png");
  btn1.classList.replace('btn-sub', 'btn-sub-go');
  btn2.classList.replace('btn-sub', 'btn-sub-go');
  combined.getContext('2d').drawImage(canvas, 0, 0);
  combined.getContext('2d').drawImage(canvas2, document.getElementById('video_overlays').offsetLeft, document.getElementById('video_overlays').offsetTop);
}

function removecvs()
{
    ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    document.getElementById('tar').value='';
    document.getElementById('ov-left').value='';
    document.getElementById('ov-top').value='';
    btn1.classList.replace('btn-sub-go', 'btn-sub');
    btn2.classList.replace('btn-sub-go', 'btn-sub');
}

/* Moving */
var data = document.getElementById('video_overlays');
dragElement(document.getElementById("video_overlays"));

function dragElement(elmnt) {
  var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
  if (document.getElementById(elmnt.id + "_img")) {
    document.getElementById(elmnt.id + "_img").onmousedown = dragMouseDown;
  } else {
    elmnt.onmousedown = dragMouseDown;
  } 

  function dragMouseDown(e) {
    e = e || window.event;
    e.preventDefault();
    pos3 = e.clientX;
    pos4 = e.clientY;
    document.onmouseup = closeDragElement;
    document.onmousemove = elementDrag;
  }

  function elementDrag(e) {
    e = e || window.event;
    e.preventDefault();
    pos1 = pos3 - e.clientX;
    pos2 = pos4 - e.clientY;
    pos3 = e.clientX;
    pos4 = e.clientY;
    elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
    elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
    if(parseInt(elmnt.style.left) > 360 || parseInt(elmnt.style.top) > 150 || parseInt(elmnt.style.top) < -100 ||parseInt(elmnt.style.left) < 0){
      elmnt.style.top = "0px";
      elmnt.style.left = "0px";
      closeDragElement;
    }
  }
  function closeDragElement() {
    document.onmouseup = null;
    document.onmousemove = null;
  }
}
var f = function(){

  function eventHandler(event){
      var width = parseInt(window.getComputedStyle(this).width);
      var height = parseInt(window.getComputedStyle(this).height);
      var zoom = 5;

      if(event.wheelDelta > 0){
          this.style.width = Math.min(1500,width + zoom) + "px";
          this.style.height = Math.min(1500,height + zoom) + "px";
      }
      else{
          this.style.width = Math.max(200,width - zoom) + "px";
          this.style.height = Math.max(200,height - zoom) + "px";
      }
      if((this.style.width === "250px" || this.style.height === "250px") || (this.style.width === "250px" && this.style.height === "250px")){
        this.style.width = "200px";
        this.style.height = "200px";
      }
      event.preventDefault();
  }
  var imageElement = document.getElementById('video_overlays_img');
  imageElement.addEventListener('mousewheel',eventHandler,false);
};

window.addEventListener('load',f,false);
window.onload = init;