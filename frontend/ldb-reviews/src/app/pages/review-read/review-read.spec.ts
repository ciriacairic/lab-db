import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ReviewRead } from './review-read.component';

describe('ReviewRead', () => {
  let component: ReviewRead;
  let fixture: ComponentFixture<ReviewRead>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ReviewRead]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ReviewRead);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
