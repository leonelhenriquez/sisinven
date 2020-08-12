
class Dialog{
	constructor(){
		this.id = Util.generateId();
		this.closeIconButton = false;
		this.overlayClose = false;
		this.overlayCloseEvent = new Array();
		this.hideEvents = new Array();
		$("body").append(`
						<div class="dialog close_dialog" id="dialog`+this.id+`" style="display:none;">
							<div class="dialog-box">
								<div class="close_button" style="display:none;"><span class="material-icons">close</span></div>
								<h3 class="dialog__title"></h3>
								<div class="dialog__content"></div>
								<div class="dialog__actions"></div>
							</div>
						</div>
						`);
		$("#"+this.getId()+" .dialog__title,#"+this.getId()+" .dialog__actions").css({'display':'none'});
		var root = this;
		$("#"+this.getId()).click((e) => {
			if (root.isOverlayClose()) {
				if(e.target==e.currentTarget){
					root.hide();
					root.overlayCloseEvent.forEach((event) => {
						setTimeout(event, 0);
					});
				}
			}
		});
		$("#"+this.getId()+">.dialog-box>.close_button").click((e) => {
			root.hide();
		});
	}

	getId(){
		return "dialog"+this.id;
	}

	setTitle(title){
		$("#"+this.getId()+" .dialog__title").html(title).css({'display':'block'});
		return this.resizeDialog();
	}

	setContent(content){
		$("#"+this.getId()+" .dialog__content").html(content);
		return this.resizeDialog();
	}

	setActions(actions){
		var content = $("#"+this.getId()+" .dialog__actions");
		content.html("").css({'display':'block'});
		if (Util.isArray(actions)) {
			actions.forEach((element) => {
				content.append('<button type="button" class="btn btn-primary">'+element+'</button>');
			});
		}else{
			content.html("");
			content.append('<button type="button" class="btn btn-primary">'+actions+'</button>');
		}
		return this.resizeDialog();
	}

	setFullSize(isFullSize){
		if(isFullSize){
			$("#"+this.getId()).addClass("dialog__full-size");
		}else{
			$("#"+this.getId()).removeClass("dialog__full-size");
		}
		return this.resizeDialog();
	}

	getTitle(){
		return $("#"+this.getId()+" .dialog__title > *");
	}

	getContent(){
		return $("#"+this.getId()+" .dialog__content > *");
	}

	getActions(){
		return $("#"+this.getId()+" .dialog__actions > *");
	}

	getAction(n){
		return this.getActions()[n];
	}

	setOverlayClose(overlayClose){
		this.overlayClose = overlayClose;
		return this;
	}

	setOverlayCloseEvent(e){
		this.overlayCloseEvent.push(e);
		return this;
	}

	isOverlayClose(){
		return this.overlayClose;
	}

	setActionClick(n,event){
		$(this.getAction(n)).click(event);
		return this;
	}

	isCloseIconButton(){
		return this.closeIconButton;
	}

	setCloseIconButton(closeIconButton){
		this.closeIconButton = closeIconButton;
		$("#"+this.getId()+">.dialog-box>.close_button").css({'display': this.isCloseIconButton() ? 'block' : 'none'});
		return this;
	}

	show(){
		$("#"+this.getId()).removeClass("close_dialog");
		
		$("#"+this.getId()).css({'display':'block'});

		$(document.body).addClass('showDialog');

		return this;
	}

	hide(){
		if($("body .dialog:not(.close_dialog)").length==1){
			$(document.body).removeClass('showDialog');
		}
		$("#"+this.getId()).addClass("close_dialog");
		var root = this;
		setTimeout(() => {
			$("#"+root.getId()).css({'display':'none'});
		}, 350);
		this.hideEvents.forEach((event) => {
			setTimeout(event, 0);
		});
		return this;
	}

	destroy(){
		var id = this.getId();
		setTimeout(() => {
			$("#"+id).remove();
			id = null;
		}, 500);
		delete this;
	}

	resizeDialog(){
		return this;
	}

	addHideEvent(event){
		this.hideEvents.push(event);
		return this;
	}

	addClassDialog(class_name){
		$("#"+this.getId()).addClass(class_name);
		return this;
	}

	removeClassDialog(class_name){
		$("#"+this.getId()).removeClass(class_name);
		return this;
	}

	addClassDialogCard(class_name){
		$("#"+this.getId()+" .dialog-box").addClass(class_name);
		return this;
	}

	removeClassDialogCard(class_name){
		$("#"+this.getId()+" .dialog-box").removeClass(class_name);
		return this;
	}

	addScript(script){
		$("#"+this.getId()).append('<script type="text/javascript">'+script+'</script>');
	}
}

class LoadingDialog extends Dialog{
	constructor(){
		super();
		this.addClassDialog("loading__dialog");
		this.setContent(`
			<div class="progress-circular">
				<div class="progress-circular-wrapper">
					<div class="progress-circular-inner">
						<div class="progress-circular-left">
							<div class="progress-circular-spinner"></div>
						</div>
						<div class="progress-circular-gap"></div>
						<div class="progress-circular-right">
							<div class="progress-circular-spinner"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="text__loading">Cargando...</div>
		`);
	}
	setLoadingText(str){
		$("#"+this.getId()+" .text__loading").html(str);
		return this;
	}
}

class ErrorDialog extends Dialog{
	constructor(){
		super();
		var root = this;
		this.addClassDialog("error__dialog").setCloseIconButton()
		.setTitle("Error")
		.setActions(['OK'])
		.setActionClick(0,() => {
			root.hide();
		})
		.addHideEvent(() => {
			root.destroy();
		})

	}
	setTextError(str){
		this.setContent(str);
		return this;
	}
}

$.ajaxSetup({
	type: 'POST',
	timeout: 300000,	
	aysnc:false,
	cache: false,
	contentType: false,
	processData: false,
	error: () => {
		setTimeout(() => {
			console.log("Se a perdido la conexión.");
			var dialogError = new ErrorDialog();
			dialogError.setOverlayClose(true);
			dialogError.setOverlayCloseEvent(() => {
				dialogError.hide();
			});
			dialogError.setTextError("Se a perdido la conexión de red.");
			dialogError.show();
		}, 10);
	},
	statusCode: {
		404: () => {
			setTimeout(() => {
				var dialogError = new ErrorDialog();
				dialogError.setOverlayClose(true);
				dialogError.setOverlayCloseEvent(() => {
					dialogError.hide();
				});
				dialogError.setTextError("Error 404: La pagina no existe.");
				dialogError.show();
			}, 10);
		}
	}
});

class Util{
	static parseFormData(data){
		var form_data = null;
		if(Util.isFormData(data)){
			return data;
		}else{
			form_data = new FormData();
			for(var key in data){
				form_data.append(key, data[key]);
			}
		}
		return form_data;
	}
	static post(post_url,post_data,callback){

		post_url 	= location.origin+'/'+post_url;
		post_data 	= (typeof post_data === 'undefined') ? new FormData() : post_data;
		callback 	= (typeof callback === 'undefined') ? ()=>{} : callback;
		
		post_data 	= Util.parseFormData(post_data);
		
		$.post(post_url,post_data,callback);

	}
	static isArray(value) {
		return value && typeof value === 'object' && value.constructor === Array;
	}
	static isFormData(value) {
		return value && typeof value === 'object' && value.constructor === FormData;
	}
	static generateId() {
		// Math.random should be unique because of its seeding algorithm.
		// Convert it to base 36 (numbers + letters), and grab the first 9 characters
		// after the decimal.
		return '_' + Math.random().toString(36).substr(2, 9);
	}
	static getSize(list){
		var size = 0;
		$.each(list, () => size++);
		return size;
	}
}



var curCharLenght = 0;
var floatOptions = {
	onKeyPress: function(cur, e, currentField, floatOptions) {
		var mask = createMoneyMask(cur);
		var field = currentField
			.parent()
			.find(".input-float[data-field=" + currentField.attr("data-field") + "]");
		if (cur.length - curCharLenght < 0 && cur.indexOf(".") == -1) {
			field.mask(mask + " 000", floatOptions);
			curCharLenght = cur.length;
		} else if (event.data == "," || event.data == ".") {
			curCharLenght = mask.length + 1;
			mask += ".0000";
			field.mask(mask, floatOptions);
		} else {
			if (cur.indexOf(".") == -1) {
				mask = mask + " 000.0000";
				field.mask(mask, floatOptions);
				if (isNaN(e.originalEvent.data) || e.originalEvent.data == " ") {
					field.val(field.val().slice(0, -1));
				}
			}
			curCharLenght = cur.length;
		}
	}
};

function createMoneyMask(val) {
	if(val == null || val == "")
		 return "# ###.00";
	var mask = "";
	var num = val.split(".")[0];
	num = num.replace(/ /g, "");
	for (var i = 1; i <= num.length; i++) {
		mask += "0";
		if ((num.length - i) % 3 === 0 && i != num.length) {
			mask += " ";
		}
	}
	return mask;
}

var eachMoneyMask = function(index, el) {
	var item = $(this);
	item.attr("data-field", "field-" + index);

	var mask = createMoneyMask(item.val());
	if (item.val().indexOf(".") !== -1) {
		var splitedVal = item.val().split(".");
		if (splitedVal.length > 1 && splitedVal[1].length > 2) {
			if (splitedVal[1].length == 3) {
				mask += ".000";
			} else {
				mask += ".0000";
			}
		} else {
			mask += ".00";
		}
	}

	item.mask(mask, floatOptions);
}


