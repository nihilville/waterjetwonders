(function($) {
	'use strict';

	$(function() {
		const consentBarCookieName = thegem_gdpr_options.consent_bar_cookie_name;

		var $consentBar = $('.gdpr-consent-bar');

		$('.btn-gdpr-privacy-preferences-close').on('click', function() {
			$('.gdpr-privacy-preferences').fadeOut(300);
		});

		$('.btn-gdpr-preferences, .btn-gdpr-preferences-open').on('click', function(e) {
			e.preventDefault();
			$('.gdpr-privacy-preferences').fadeIn(300);
			return false;
		});

		$('.btn-gdpr-agreement').on('click', function() {
			if ($consentBar.hasClass('top') && !isShowAdminBar()) {
				$('html').animate({'margin-top': 0}, 400);
			}

			var $siteFixedHeader = $('#site-header.fixed');
			if (!getCookie(consentBarCookieName) && $siteFixedHeader.length > 0 && $consentBar.hasClass('top')) {
				$siteFixedHeader.animate({'top': 0}, 300);
				console.log('hide cookie bar');
			}

			$('.gdpr-consent-bar').fadeOut();
			setCookie(consentBarCookieName, 1);
		});

		$('.gdpr-privacy-preferences').on('click', function() {
			if ($(event.target).find('.gdpr-privacy-preferences-box').length>0) {
				$('.gdpr-privacy-preferences').fadeOut(300);
			}
		});

		function initConsentBar() {
			if ($consentBar.length > 0) {
				if ($consentBar.hasClass('top') && !isShowAdminBar()) {
					$('html').css({'margin-top': $consentBar.height()+'px'});
				}
				$consentBar.fadeIn();
			}
		}

		function setCookie(name, value, days = 365) {
			var date = new Date();
			date.setTime(date.getTime() + (days*24*3600*1000));
			var expires = '; expires=' + date.toUTCString();
			document.cookie = name + '=' + (value || '')  + expires + '; path=/';
		}

		function getCookie(name) {
			var value = '; ' + document.cookie;
			var parts = value.split('; ' + name + '=');

			if (parts.length === 2) {
				return parts.pop().split(';').shift();
			}
			return false;
		}

		function isShowAdminBar() {
			return $('#wpadminbar').length > 0;
		}

		function fixSiteFixedHeader() {
			var $siteFixedHeader = $('#site-header.fixed');
			if (!getCookie(consentBarCookieName) && $siteFixedHeader.length > 0 && $consentBar.hasClass('top')) {
				$siteFixedHeader.css({'top': $consentBar.outerHeight()+'px'});
			}
		}

		$(window).on('scroll', function() {
			fixSiteFixedHeader();
		});

		$(window).on('load', function() {
			fixSiteFixedHeader();
		});

		$(window).on('resize', function() {
			fixSiteFixedHeader();
		});

		initConsentBar();

	});
})(jQuery);
