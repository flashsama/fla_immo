(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$(function() {
		$('#update_annonce_btn').click(function (e){
			e.preventDefault();
			//show loading
			$('form>.progress').show();
			//disable button
			$('#update_annonce_btn').attr('disabled',true);
			//validate and collect form data
			var annonce_data = {id:parseInt($('#annonce_id').val(), 10)};

			annonce_data.title = $('#annonce_title').val();
			annonce_data.type_de_transactiion = $('#type_de_transaction :selected').val();
			annonce_data.type_doffre = $('#type_doffre :selected').val();
			annonce_data.secteur = $('#secteur :selected').val();
			annonce_data.description = $('#annonce_description').val();
			annonce_data.surface = $('#annonce_surface').val();
			annonce_data.surface2 = $('#annonce_surface_2').val();
			annonce_data.longitude = $('#annonce_longitude').val();
			annonce_data.latitude = $('#annonce_latitude').val();
			annonce_data.prix = $('#annonce_prix').val();
			annonce_data.unite = $('#annonce_unite').val();
			annonce_data.num_mandat = $('#annonce_numero_de_mandat').val();
			annonce_data.ref_interne = $('#annonce_reference_interne').val();
			annonce_data.annonce_img_id = parseInt($('#annonce_img_id').val(),10);
			annonce_data.commission = ($('#annonce_commission').prop('checked'))?1:0;

			$.ajax({
				type : 'POST',
				url  : ajax_front_obj.ajax_url+'?action=update_annonce_immo',
				data : annonce_data,
				success : function(res) {
					res = JSON.parse(res);
					console.log(res);
					if(res.status == 'success') {
						location.reload();
					}else {
						
						$('#error_update_annonce').show();
					}
					$('form>.progress').hide();
					$('#update_annonce_btn').attr('disabled',false);
				} 
			});

		 });//end click

		 $('#add_new_annonce_btn').click(function (e) {
			e.preventDefault();

			//show loading
			$('form>.progress').show();
			//disable button
			$('#add_new_annonce_btn').attr('disabled',true);
			//validate and collect form data
			var annonce_data = {};
			if ($('#annonce_title').val().length < 3) {
				//show error and return
				$('#annonce_title').addClass('invalid');
				$('form>.progress').hide();
				$('#add_new_annonce_btn').attr('disabled',false);
				$('#annonce_title').focus();
				return;
			}else {
				$('#annonce_title').removeClass('invalid');
				$('#annonce_title').addClass('valid');
				annonce_data.title = $('#annonce_title').val();
			}
			
			annonce_data.type_de_transactiion = $('#type_de_transaction :selected').val();
			annonce_data.type_doffre = $('#type_doffre :selected').val();
			annonce_data.secteur = $('#secteur :selected').val();
			annonce_data.description = $('#annonce_description').val();
			annonce_data.surface = $('#annonce_surface').val();
			annonce_data.surface2 = $('#annonce_surface_2').val();
			annonce_data.longitude = $('#annonce_longitude').val();
			annonce_data.latitude = $('#annonce_latitude').val();
			annonce_data.prix = $('#annonce_prix').val();
			annonce_data.unite = $('#annonce_unite').val();
			annonce_data.num_mandat = $('#annonce_numero_de_mandat').val();
			annonce_data.ref_interne = $('#annonce_reference_interne').val();
			annonce_data.commission = ($('#annonce_commission').prop('checked'))?1:0;
			annonce_data.annonce_img_id = parseInt($('#annonce_img_id').val(),10);

			if (parseInt($('#annonce_agence').val(),10) == 0) {
				
				//show error and return
				$('#annonce_agence_wrapper>.select-wrapper>input.select-dropdown').addClass('invalid');
				$('form>.progress').hide();
				$('#add_new_annonce_btn').attr('disabled',false);
				$('#annonce_agence_wrapper>.select-wrapper>input.select-dropdown').focus();
				return;
			} else {

				$('#annonce_agence_wrapper>.select-wrapper>input.select-dropdown').removeClass('invalid');
				$('#annonce_agence_wrapper>.select-wrapper>input.select-dropdown').addClass('valid');
				annonce_data.agence = parseInt($('#annonce_agence :selected').val(),10);
			}

			$.ajax({
				type  : 'POST',
				url   : ajax_front_obj.ajax_url+'?action=add_new_annonce_immo',
				data  : annonce_data,
				success : function(res) {
					res = JSON.parse(res);
					console.log(res);
					if(res.status == 'success') {
						//location.reload();
						location.href = res.result;
					}else {
						$('#error_new_annonce').show();
					}
					$('form>.progress').hide();
					$('#add_new_annonce_btn').attr('disabled',false);
				}
			});//end ajax


		 });//end click

		 var customUploader;

		 $('#upload_annonce_img_btn').click(function (e) {
			e.preventDefault();

			customUploader = wp.media({
				title: 'Choisir une image',
				button : {
					text : 'Selectioner'
				},
				multiple: false
			});//custom uploader declaration

			if (customUploader) {
				customUploader.open();
			}

			//add event listener when image selected from wp media popup
			customUploader.on('select', function () {
				var imgAttachement = customUploader.state().get('selection').first().toJSON();
				console.log(imgAttachement);
				$('#annonce_img').prop('src', imgAttachement.url);
				$('#annonce_img_id').val(imgAttachement.id);
			});
		 });//end click
		 $('#upload_agence_vitrine_btn, #upload_agence_logo_btn').click(function (e) {
			e.preventDefault();

			console.log(e.currentTarget.id);


			customUploader = wp.media({
				title: 'Choisir une image',
				button : {
					text : 'Selectioner'
				},
				multiple: false
			});//custom uploader declaration

			if (customUploader) {
				customUploader.open();
			}

			//add event listener when image selected from wp media popup
			customUploader.on('select', function () {
				var imgAttachement = customUploader.state().get('selection').first().toJSON();
				switch (e.currentTarget.id) {
					case 'upload_agence_logo_btn':
						$('#agence_logo').prop('src', imgAttachement.url);
						$('#agence_logo_id').val(imgAttachement.id);
						break;
					case 'upload_agence_vitrine_btn':
						$('#agence_vitrine').prop('src', imgAttachement.url);
						$('#agence_vitrine_id').val(imgAttachement.id);
						break;
				
					default:
						break;
				}
			});
		 });//end click

		 $('#update_agence_btn').click(function (e){
			e.preventDefault();

			//show loading
			$('form>.progress').show();
			//disable button
			$('#update_agence_btn').attr('disabled',true);
			//validate and collect form data

			var agenceData = {id:parseInt($('#agence_id').val(),10)};


			if ($('#agence_title').val().length < 3) {
				//show error and return
				$('#agence_title').addClass('invalid');
				$('form>.progress').hide();
				$('#update_agence_btn').attr('disabled',false);
				$('#agence_title').focus();
				return;
			}else {
				$('#agence_title').removeClass('invalid');
				$('#agence_title').addClass('valid');
				agenceData.title = $('#agence_title').val();
			}
			if ($('#agence_responsable').val().length < 3) {
				//show error and return
				$('#agence_responsable').addClass('invalid');
				$('form>.progress').hide();
				$('#update_agence_btn').attr('disabled',false);
				$('#agence_responsable').focus();
				return;
			}else {
				$('#agence_responsable').removeClass('invalid');
				$('#agence_responsable').addClass('valid');
				agenceData.responsable = $('#agence_responsable').val();
			}
			if ($('#agence_description').val().length < 3) {
				//show error and return
				$('#agence_description').addClass('invalid');
				$('form>.progress').hide();
				$('#update_agence_btn').attr('disabled',false);
				$('#agence_description').focus();
				return;
			}else {
				$('#agence_description').removeClass('invalid');
				$('#agence_description').addClass('valid');
				agenceData.presentation = $('#agence_description').val();
			}
			var emailpattern = /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i;
			if (!$('#agence_email').val().match(emailpattern)) {
				//show error and return
				$('#agence_email').addClass('invalid');
				$('form>.progress').hide();
				$('#update_agence_btn').attr('disabled',false);
				$('#agence_email').focus();
				return;
			}else {
				$('#agence_email').removeClass('invalid');
				$('#agence_email').addClass('valid');
				agenceData.email = $('#agence_email').val();
			}
			var telPattern = /^[\s()+-]*([0-9][\s()+-]*){6,20}$/;
			if (!$('#agence_tel').val().match(telPattern)) {
				//show error and return
				$('#agence_tel').addClass('invalid');
				$('form>.progress').hide();
				$('#update_agence_btn').attr('disabled',false);
				$('#agence_tel').focus();
				return;
			}else {
				$('#agence_tel').removeClass('invalid');
				$('#agence_tel').addClass('valid');
				agenceData.tel = $('#agence_tel').val();
			}
			agenceData.site = $('#agence_site').val();
			if ($('#agence_adresse').val().length < 3) {
				//show error and return
				$('#agence_adresse').addClass('invalid');
				$('form>.progress').hide();
				$('#update_agence_btn').attr('disabled',false);
				$('#agence_adresse').focus();
				return;
			}else {
				$('#agence_adresse').removeClass('invalid');
				$('#agence_adresse').addClass('valid');
				agenceData.adresse = $('#agence_adresse').val();
			}
			if ($('#agence_ville').val().length < 3) {
				//show error and return
				$('#agence_ville').addClass('invalid');
				$('form>.progress').hide();
				$('#update_agence_btn').attr('disabled',false);
				$('#agence_ville').focus();
				return;
			}else {
				$('#agence_ville').removeClass('invalid');
				$('#agence_ville').addClass('valid');
				agenceData.ville = $('#agence_ville').val();
			}
			if ($('#agence_cp').val().length < 3) {
				//show error and return
				$('#agence_cp').addClass('invalid');
				$('form>.progress').hide();
				$('#update_agence_btn').attr('disabled',false);
				$('#agence_cp').focus();
				return;
			}else {
				$('#agence_cp').removeClass('invalid');
				$('#agence_cp').addClass('valid');
				agenceData.code_postal = $('#agence_cp').val();
			}
			agenceData.agence_logo_id = $('#agence_logo_id').val();
			agenceData.agence_vitrine_id = $('#agence_vitrine_id').val();
			console.log(agenceData);

			$.ajax({
				type   : 'POST',
				url    : ajax_front_obj.ajax_url+'?action=update_agence_immo',
				data   : agenceData,
				success : function(res) {
					res = JSON.parse(res);
					console.log(res);
					if(res.status == 'success') {
						location.reload();
					}else {
						
						$('#error_update_agence').show();
					}
					$('form>.progress').hide();
					$('#update_agence_btn').attr('disabled',false);
				}
			});//end ajax

		 });//end click

		$('.delete_offre_btn').click(function (e){
			e.preventDefault();
			var offreIDToDelete = parseInt($(this).attr('data'),10);
			$('#offre_id_to_delete').val(offreIDToDelete);
			$('#delete_confirm_modal').modal('open');
		});//end click

		$('.archive_offre_btn').click(function (e){
			e.preventDefault();
			var offreIDToArchive = parseInt($(this).attr('data'),10);
			$('#offre_id_to_archive').val(offreIDToArchive);
			$('#archive_confirm_modal').modal('open');
		});//end click

		$('#archive_offre_immo_confirm').click(function(e){
			e.preventDefault();

			//show loading
			$('.preloader-wrapper').show();
			//disable buttons
			$('#archive_offre_immo_confirm').attr('disabled', true);
			$('#archive_confirm_modal .modal-footer .modal-close').attr('disabled', true);
			var id_to_archive = parseInt($('#offre_id_to_archive').val());
			//send ajax request to archive
			$.ajax({
				type : 'post',
				url : ajax_front_obj.ajax_url+'?action=archive_offre_immo',
				data : {'id_to_archive':id_to_archive},
				success: function (res) {
					console.log(res);
					res = JSON.parse(res);
					if (res.status == 'success') {
						//post status changed to trash
						//hide loading
						$('.preloader-wrapper').hide();
						//enable buttons
						$('#archive_offre_immo_confirm').attr('disabled', false);
						$('#archive_confirm_modal .modal-footer .modal-close').attr('disabled', false);
						//close modal
						$('#archive_confirm_modal').modal('close');
						//archive post row
						$('#item_'+id_to_archive).slideUp(1000,function(){
							$('#item_'+id_to_archive).remove();
						});

					}else {
						//post status not changed
						//hide loading
						$('.preloader-wrapper').hide();
						//show error
						$('#archive_confirm_modal .error_container').show();
					}
				}
			});
		});//end click

	});//end dom ready
	 
})( jQuery );
