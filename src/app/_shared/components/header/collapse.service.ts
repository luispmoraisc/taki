import { Injectable } from '@angular/core';
import { Router, NavigationStart } from '@angular/router';
import { Observable } from 'rxjs';
import { Subject } from 'rxjs/Subject';


@Injectable()
export class CollapseService{
	private subject = new Subject<any>();	
	private keepAfterRouteChange = false;
	private collapseVar : boolean = false;	
	constructor(private router: Router){
		router.events.subscribe(event => {
            if (event instanceof NavigationStart) {
                if (this.keepAfterRouteChange) {
                    // mantenha apenas uma única mudança de rota
                    this.keepAfterRouteChange = false;
                }
            }
        });
	}	

	getCollapse(): Observable<any>{
		return this.subject.asObservable();
	}

	collapse() { 			
		this.collapseVar = this.collapseVar ? false : true;
        this.subject.next(this.collapseVar);
    }

    clear() {
        // clear alerts
        this.subject.next();
    }    
}