<?php

class Jquery {
	public static function form() {
		Engine::directScript("jquery/form/jquery.form.js");
	}

	public static function datatable() {
		Engine::directScript("jquery/datatable/jquery.dataTables.js");
		Engine::directStyle("jquery/datatable/demo_table_jui.css");
		Engine::directStyle("jquery/datatable/demo_page.css");
	}

	public static function datatable_jedit() {
		Engine::directScript("jquery/datatable/jquery.dataTables.js");
		Engine::directScript("jquery/datatable/jEditable.js");
		Engine::directStyle("jquery/datatable/demo_table_jui.css");
		Engine::directStyle("jquery/datatable/demo_page.css");
	}

	public static function inline_validation() {
		Engine::directScript("jquery/inline_validation/jquery.validationEngine-en.js");
		Engine::directScript("jquery/inline_validation/jquery.validationEngine.js");
		Engine::directStyle("jquery/inline_validation/validationEngine.jquery.css");
	}

	public static function jbar() {
		Engine::directScript("jquery/jbar/jquery.bar.js");
	}

	public static function tipsy() {
		Engine::directScript("jquery/tipsy/jquery.tipsy.js");
		Engine::directStyle("jquery/tipsy/tipsy.css");
	}

	public static function plup_uploader() {
		Engine::directStyle("jquery/plup_uploader/jquery.plupload.queue.css");
		Engine::directScript("jquery/plup_uploader/plupload.full.js");
		Engine::directScript("jquery/plup_uploader/jquery.plupload.queue.js");
	}

	public static function blueimp_uploader() {
		Engine::directStyle("jquery/fileuploader/jquery.fileupload-ui.css");
		Engine::directScript("jquery/fileuploader/jquery.ui.widget.js");
		Engine::directScript("jquery/fileuploader/tmpl.min.js");
		Engine::directScript("jquery/fileuploader/load-image.min.js");
		Engine::directScript("jquery/fileuploader/canvas-to-blob.min.js");
		Engine::directScript("jquery/fileuploader/jquery.blueimp-gallery.min.js");
		Engine::directScript("jquery/fileuploader/jquery.fileupload.js");
		Engine::directScript("jquery/fileuploader/jquery.fileupload-process.js");
		Engine::directScript("jquery/fileuploader/jquery.fileupload-image.js");
		Engine::directScript("jquery/fileuploader/jquery.fileupload-validate.js");
		Engine::directScript("jquery/fileuploader/jquery.fileupload-ui.js");
		Engine::directScript("jquery/fileuploader/main.js");
		
	}

	public static function select2() {
		Engine::directStyle("jquery/select2/select2.css");
		Engine::directScript("jquery/select2/select2.js");
	}

	public static function signaturepad() {
		Engine::directStyle("jquery/signaturepad/assets/jquery.signaturepad.css");
		Engine::directScript("jquery/signaturepad/assets/flashcanvas.js");
		Engine::directScript("jquery/signaturepad/jquery.signaturepad.js");
		Engine::directScript("jquery/signaturepad/assets/json2.min.js");
	}

	/*
	public static function uploader() {
		Engine::directStyle("jquery/uploader/bootstrap.min.css");
		Engine::directStyle("jquery/uploader/bootstrap-responsive.min.css");
		Engine::directStyle("jquery/uploader/jquery.fileupload-ui.css");

		
		Engine::directScript("jquery/uploader/jquery.min.1.10.js");
		Engine::directScript("jquery/uploader/jquery.ui.widget.js");
		Engine::directScript("jquery/uploader/jquery.iframe-transport.js");
		Engine::directScript("jquery/uploader/jquery.fileupload.js");
		
	}
	*/
}

?>