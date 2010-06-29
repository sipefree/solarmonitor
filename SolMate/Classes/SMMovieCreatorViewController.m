//
//  SMMovieCreatorViewController.m
//  SolMate
//
//  Created by Simon Free on 24/06/2010.
//  Copyright 2010 SolarMonitor.org. All rights reserved.
//

#import "SMMovieCreatorViewController.h"
#import "SMMainViewController.h"
#import "SMAppDelegate.h"
#import "NSDate+yyyymmdd.h"
#import "NSString+SBJSON.h"

@implementation SMMovieCreatorViewController
@synthesize
startDateSetButton,
endDateSetButton,
goButton,
playButton,
rewindButton,
fastForwardButton,
progressView,
imageView,
fpsField,
activity,
timeStamp,
type,
datePicker,
dateControlView,
hideDateControlButton;

- (void)viewDidLoad {
    [super viewDidLoad];
    self.view.backgroundColor = [UIColor viewFlipsideBackgroundColor];      
	self.activity.hidden = YES;
	self.progressView.progress = 0.0;
	self.progressView.progressViewStyle = UIProgressViewStyleBar;
	self.startDateSetButton.titleLabel.text = @"Click to Set";
	self.endDateSetButton.titleLabel.text = @"Click to Set";
	self.goButton.enabled = NO;
	startDate = nil;
	endDate = nil;
	self.fpsField.text = @"9.0";
	fps = 9.0;
	
	SMMainViewController* controller = (SMMainViewController*)self.delegate;
	self.datePicker = controller.datePicker;
	self.dateControlView = controller.dateControlView;
	[self.dateControlView removeFromSuperview];
	[self.view addSubview:self.dateControlView];
	self.dateControlView.alpha = 0.0;
	self.hideDateControlButton = controller.hideDateControlButton;
	[self.hideDateControlButton removeTarget:controller action:@selector(hideDateControl) forControlEvents:UIControlEventTouchUpInside];
	[self.hideDateControlButton addTarget:self action:@selector(hideDateControl) forControlEvents:UIControlEventTouchUpInside];
	settingStartDate = NO;
	settingEndDate = NO;
	
	SMAppDelegate* appDelegate = (SMAppDelegate*)[[UIApplication sharedApplication] delegate];
	animationDataSource = appDelegate.animationDataSource;
	animationDataSource.delegate = self;
	animationDataSource.anim_delegate = self;
	[animationDataSource setValue:type forParameterKey:@"type"];
	
	animationNeedsUpdate = YES;
	isLoading = NO;
}
- (void)showDateControl {
	self.dateControlView.hidden = NO;
	[self.view bringSubviewToFront:self.dateControlView];
	self.dateControlView.frame = CGRectMake(
											0.0,
											[[UIScreen mainScreen] bounds].size.height,
											self.dateControlView.frame.size.width,
											self.dateControlView.frame.size.height);
	self.dateControlView.alpha = 0.0;
	[UIView beginAnimations:nil context:nil];
	[UIView setAnimationDuration:0.4];
	self.dateControlView.frame = CGRectMake(
											0.0,
											0.0,
											self.dateControlView.frame.size.width,
											self.dateControlView.frame.size.height);
	self.dateControlView.alpha = 1.0;
	[UIView commitAnimations];
}
- (void)hideDateControl {
	[self.view bringSubviewToFront:self.dateControlView];
	[UIView beginAnimations:nil context:nil];
	[UIView setAnimationDuration:0.4];
	self.dateControlView.frame = CGRectMake(
											0,
											[[UIScreen mainScreen] bounds].size.height,
											self.dateControlView.frame.size.width,
											self.dateControlView.frame.size.height);
	self.dateControlView.alpha = 0.0;
	[UIView commitAnimations];
	if(settingStartDate) {
		startDate = [self.datePicker date];
		self.startDateSetButton.titleLabel.text = [NSString stringWithFormat:@"%i",[startDate dateAsYYYYMMDD]];
		settingStartDate = false;
	} else {
		endDate = [self.datePicker date];
		self.endDateSetButton.titleLabel.text = [NSString stringWithFormat:@"%i",[endDate dateAsYYYYMMDD]];
		settingEndDate = false;
	}
	if(startDate && endDate) {
		self.goButton.enabled = YES;
	}
	animationNeedsUpdate = YES;
}

- (void)setType:(NSString *)aString {
	type = aString;
}
- (IBAction)back {
	[self.dateControlView removeFromSuperview];
	SMMainViewController* controller = (SMMainViewController*)self.delegate;
	[controller.view addSubview:self.dateControlView];
	[animationDataSource setValue:@"" forParameterKey:@"startdate"];
	[animationDataSource setValue:@"" forParameterKey:@"enddate"];
	[animationDataSource setValue:@"" forParameterKey:@"type"];
	animationDataSource.delegate = controller;
	animationDataSource.anim_delegate = controller;
	[self.hideDateControlButton removeTarget:self action:@selector(hideDateControl) forControlEvents:UIControlEventTouchUpInside];
	[self.hideDateControlButton addTarget:controller action:@selector(hideDateControl) forControlEvents:UIControlEventTouchUpInside];
	[self.delegate flipsideViewControllerDidFinish:self];
}
- (IBAction)setStartDate {
	if(endDate != nil) {
		self.datePicker.maximumDate = endDate;
		self.datePicker.minimumDate = [NSDate dateWithTimeIntervalSince1970:820454400];
		self.datePicker.date = (startDate == nil) ? endDate : startDate;
	} else {
		self.datePicker.maximumDate = [NSDate dateWithTimeIntervalSinceNow:0];
		self.datePicker.minimumDate = [NSDate dateWithTimeIntervalSince1970:820454400];
		self.datePicker.date = self.datePicker.maximumDate;
	}
	settingStartDate = YES;
	[self showDateControl];
}
- (IBAction)setEndDate {
	if(startDate != nil) {
		self.datePicker.maximumDate = [NSDate dateWithTimeIntervalSinceNow:0];
		self.datePicker.minimumDate = startDate;
		self.datePicker.date = (endDate == nil) ? startDate : endDate;
	} else {
		self.datePicker.maximumDate = [NSDate dateWithTimeIntervalSinceNow:0];
		self.datePicker.minimumDate = [NSDate dateWithTimeIntervalSince1970:820454400];
		self.datePicker.date = self.datePicker.maximumDate;
	}
	settingEndDate = YES;
	[self showDateControl];
}
- (IBAction)go {
	if(isLoading) {
		[animationDataSource cancel];
		self.activity.hidden = YES;
		self.progressView.progress = 0.0;
		self.progressView.progressViewStyle = UIProgressViewStyleBar;
		self.imageView.image = nil;
		self.imageView.animationImages = nil;
		self.imageView.animationRepeatCount = 0;
		[self.goButton setTitle:@"Go" forState:UIControlStateNormal];
		[self.goButton setTitle:@"Go" forState:UIControlStateHighlighted];
		[self.goButton setTitle:@"Go" forState:UIControlStateSelected];
		animationNeedsUpdate = YES;
		isLoading = NO;
	}
	else if(animationNeedsUpdate) {
		[animationDataSource setValue:[NSString stringWithFormat:@"%i",[startDate dateAsYYYYMMDD]] forParameterKey:@"startdate"];
		[animationDataSource setValue:[NSString stringWithFormat:@"%i",[endDate dateAsYYYYMMDD]] forParameterKey:@"enddate"];
		[animationDataSource update];
		self.activity.hidden = NO;
		[self.activity startAnimating];
		[self.goButton setTitle:@"Stop" forState:UIControlStateNormal];
		[self.goButton setTitle:@"Stop" forState:UIControlStateHighlighted];
		[self.goButton setTitle:@"Stop" forState:UIControlStateSelected];
		isLoading = YES;
	} else {
		[self animationDidFinishLoading:animationDataSource];
	}
}
- (IBAction)play {
	[self.imageView startAnimating];
}
- (IBAction)rewind {
	
}
- (IBAction)fastForward {
	
}
- (BOOL)textFieldShouldReturn:(UITextField *)textField {
	[textField resignFirstResponder];
	double val = ceil([textField.text doubleValue]);
	if(val == 0.0)
		val = 9.0;
	textField.text = [NSString stringWithFormat:@"%.1f",(float)val];
	fps = val;
	return NO;
}
- (void)dataSourceDidStartLoading:(JSONDataSource*)ds {
	self.progressView.progress = 0.0;
	self.progressView.progressViewStyle = UIProgressViewStyleBar;
}
- (void)dataSourceDidFinishLoading:(JSONDataSource*)ds {
	[animationDataSource preloadImages];
}
- (void)animationDidFinishLoading:(SMAnimationDataSource*)sender {
	self.activity.hidden = YES;
	self.progressView.progress = 0.0;
	self.progressView.progressViewStyle = UIProgressViewStyleDefault;
	NSArray* keys = [[[animationDataSource preloadedImages] allKeys] sortedArrayUsingSelector:@selector(compareNumerically:)];
	NSMutableArray* imageArray = [NSMutableArray arrayWithCapacity:[keys count]];
	for(NSString* key in keys) {
		[imageArray addObject:[[animationDataSource preloadedImages] objectForKey:key]];
	}
	[self.imageView setImage:[imageArray objectAtIndex:0]];
	self.imageView.image = [imageArray objectAtIndex:0];
	self.imageView.animationImages = imageArray;
	self.imageView.animationRepeatCount = 0;
	double duration = (double)[imageArray count]/(double)fps;
	self.imageView.animationDuration = duration;
	[self.imageView startAnimating];
	[self.goButton setTitle:@"Go" forState:UIControlStateNormal];
	[self.goButton setTitle:@"Go" forState:UIControlStateHighlighted];
	[self.goButton setTitle:@"Go" forState:UIControlStateSelected];
	animationNeedsUpdate = NO;
	isLoading = NO;
	[animationDataSource flush];
}
- (void)animation:(SMAnimationDataSource*)sender didProgressWithCount:(int)count ofTotal:(int)total {
	self.progressView.progress = (float)count / (float)total;
}
- (void)dealloc {
	[animationDataSource cancel];
	[animationDataSource flush];
	[super dealloc];
}
@end
