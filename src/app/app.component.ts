import { Component } from '@angular/core';
import { Router, Event as RouterEvent, NavigationStart,NavigationEnd,NavigationCancel,NavigationError} from '@angular/router';
import { AlertService } from './_shared';

@Component({
	selector: 'app-root',
	templateUrl: './app.component.html',
	styleUrls: ['./app.component.scss']
})
export class AppComponent {
	load: boolean;

	constructor(
		public router: Router,
		private alertService : AlertService
	){
		router.events.subscribe((event: RouterEvent) => {this.navigationInterceptor(event)});
	}

	navigationInterceptor(event: RouterEvent){		
		if (event instanceof NavigationEnd) {
			this.hiddenSpinner();
		}		
		if (event instanceof NavigationCancel) {
			this.hiddenSpinner();
		}
		if (event instanceof NavigationError) {
			this.hiddenSpinner();
		}
	}

	hiddenSpinner(){
		setInterval(() => {
			document.getElementById('spinner').classList.add('hidden');	
		}, 1000);		
	}
}
