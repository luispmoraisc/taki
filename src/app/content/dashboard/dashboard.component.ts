import { Component, OnInit } from '@angular/core';

@Component({
	selector: 'app-dashboard',
	templateUrl: './dashboard.component.html',
	styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit {
	
	public map : any = [
		{
			label : "Dashboard",
			link : "dashboard"
		},
		{
			label : "Relatórios",
			link : "dashboard"
		},
		{
			label : "Resumo",
			link : "dashboard"
		}
	];	

	public modelFake : string;
	public yearFake : string;

	constructor() { }

	ngOnInit() {
		this.modelFake = "Semanal";
		this.yearFake = "2018";
	}

	changeAge(opt){
		this.modelFake = opt;
	}


	changeYear(opt){
		this.yearFake = opt;
	}
}
