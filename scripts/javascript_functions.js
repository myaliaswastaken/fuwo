function setHide(name)
{
	document.getElementById(name).style.display="none";
}

function setShow(name)
{
	document.getElementById(name).style.display="block";

}

function showDatas() 
{
	$.post("includes/showAllData.php",
		{
	    	1: 'start'
		}
	    ,
	    function (data) {
	    	$('#showPosts').html(data);
	    }
	);
	
}

function sendData(string)
{
	postID = 0;
	if (string == 'comment')
	{
		name = $('input[id=newCommentName]').val();
		email = $('input[id=newCommentEMail]').val();
		text = $('textarea[id=newCommentText]').val();
		time = $('input[id=timeSartComment]').val();	
		postID = $('input[id=postID]').val();
	}
	else
	{
		name = $('input[id=newPostName]').val();
		email = $('input[id=newPostEMail]').val();
		text = $('textarea[id=newPostText]').val();
		time = $('input[id=timeSart]').val();	
		string = 'newPost';
	}
		

	jetzt = new Date();
	timeNow = jetzt.getTime();
	test = timeNow - time;

	if (test > 2000)
	{
		$('input[id=PostResult]').val(test);
		setShow('PostResult');
	    $.post("includes/insertData.php",
			{
		    	1: string,
		    	2: name,
		    	3: email,
		    	4: text,
		    	5: time,
		    	6: postID
			}
		    ,
		    function (data) {
		    	$('#returnMessage').text(data);
		    }
	    );
	    showDatas();
	}
	else
	{
		$('#returnMessage').text('Das Formular wurde in unter 2 Sekunden abgeschickt -> Spam');
	}
}

//$(document).ready(
//	function() 
//	{
//		$.post("includes/showAllData.php",
//			{
//		    	1: 'start'
//			}
//		    ,
//		    function (data) {
//		    	$('#showPosts').html(data);
//		    }
//		);
//		
//	}
//);
