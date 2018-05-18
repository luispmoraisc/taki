import { Component, OnInit, Input } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { CollapseService } from './../header/collapse.service';

@Component({
	selector: 'app-sidebar',
	templateUrl: './sidebar.component.html',
	styleUrls: ['./sidebar.component.scss']
})
export class SidebarComponent implements OnInit {
	public menu : any;
	public collapse : boolean = false;

	constructor(
		private route: ActivatedRoute,
		private router: Router,
		private collapseService : CollapseService
	) {}
		
	@Input() itensMenu : any;

	ngOnInit() {		
		this.menu = this.route.snapshot.data['menu'];
		this.collapseService.getCollapse().subscribe((collapse : boolean )=>{
			this.collapse = collapse;
		});		
	}
}
