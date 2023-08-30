import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Project } from '../models/project.model';

@Injectable({
  providedIn: 'root'
})
export class ProjectService {

  url: string = '/api/project'

  constructor(private http: HttpClient) { }

  index(): Observable<Project[]> {
    return this.http.get<Project[]>(this.url);
  }

}
