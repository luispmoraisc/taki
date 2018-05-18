import { Component, OnInit, AfterViewInit } from '@angular/core';
import { Router, Event as RouterEvent, NavigationStart,NavigationEnd,NavigationCancel,NavigationError} from '@angular/router';
import { CollapseService } from './../_shared';

declare var jquery:any;
declare var $ :any;
@Component({	
  	selector: 'app-content',
  	templateUrl: './content.component.html',
  	styleUrls: ['./content.component.scss']
})
export class ContentComponent implements OnInit, AfterViewInit {

	public collapse : boolean = false;
	screen : number;

	constructor(
		public router: Router,
		private collapseService : CollapseService
		) { 
		router.events.subscribe((event: RouterEvent) => {this.navigationInterceptor(event)});
	}

	navigationInterceptor(event: RouterEvent){
		if (event instanceof NavigationStart) {
			document.getElementById('spinner').classList.add('loading');	
		}
		if (event instanceof NavigationEnd) {
			document.getElementById('spinner').classList.remove('loading');	
		}		
		if (event instanceof NavigationCancel) {
			document.getElementById('spinner').classList.remove('loading');	
		}
		if (event instanceof NavigationError) {
			document.getElementById('spinner').classList.remove('loading');	
		}
	}
		
	ngOnInit() {
		if (this.router.url === '/') {
			console.log(this.router);
			this.router.navigate(['/dashboard']);			
		}		

		this.collapseService.getCollapse().subscribe((collapse : boolean )=>{
			this.collapse = collapse;
		});		
		
	}	

	ngAfterViewInit(){		
	}	

}
