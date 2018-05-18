import { Component, OnInit } from '@angular/core';
import { Usuario } from './../../../_models/index';
import { CollapseService } from './collapse.service';
import { Constants } from './../../../_common';

@Component({
	selector: 'app-header',
	templateUrl: './header.component.html',
	styleUrls: ['./header.component.scss']
})
export class HeaderComponent implements OnInit {

	private uploadsUrl : string;
	private user : any;
	private collapse : boolean = false;

	constructor(	
		private collapseService : CollapseService	
	) {
		
	}

	ngOnInit() {
		this.user = Usuario.USER;				
		this.collapseService.getCollapse().subscribe((collapse : boolean )=>{
			this.collapse = collapse;
		});
	}


	collapseLayout(){
		this.collapseService.collapse();
	}	

}
