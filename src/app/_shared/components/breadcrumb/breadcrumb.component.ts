import { Component, OnInit, Input } from '@angular/core';

@Component({
	selector: 'app-breadcrumb',
	templateUrl: './breadcrumb.component.html',
	styleUrls: ['./breadcrumb.component.scss']
})
export class BreadcrumbComponent implements OnInit {

	@Input() local : string;
	@Input() all : any;
	constructor() { }

	ngOnInit() {
		console.log(this.local);
		console.log(this.all);
	}

}
