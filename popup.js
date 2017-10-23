let ytKey = 'AIzaSyD-h8I46aiRHWk2TmUgrC3rQ-BFTEnyvC8';
var music = 0;

document.addEventListener("DOMContentLoaded", function(event) {
	chrome.tabs.query({'active': true, 'lastFocusedWindow': true}, function (tabs) {
    	let url = tabs[0].url;
    	if(url.includes('www.youtube.com/')){
    		var video_id = url.split('v=')[1];
			var ampersandPosition = video_id.indexOf('&');
			if(ampersandPosition != -1) {
			  video_id = video_id.substring(0, ampersandPosition);
			}
    		let burl = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id=' + video_id + '&key=' + ytKey;
    		fetch(burl).then(function(response) {
			  return response.json();
			}).then(function(data) {
			   music = data.items[0].snippet.categoryId;
			  //console.log(data);
			}).catch(function() {
			  console.log("Booo");
			});
			if ((music == 10) || (music == 24)){
				onYoutube();
			}
    	}
	});
});

function onYoutube(){
	//document.getElementById("container").innerHTML = "We on youtube";
	alert('l');
}