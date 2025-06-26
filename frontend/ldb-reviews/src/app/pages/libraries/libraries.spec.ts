import { ComponentFixture, TestBed } from '@angular/core/testing';

import { Libraries } from './libraries';

describe('Libraries', () => {
  let component: Libraries;
  let fixture: ComponentFixture<Libraries>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [Libraries]
    })
    .compileComponents();

    fixture = TestBed.createComponent(Libraries);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
