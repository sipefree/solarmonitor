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
	// hide the activity indicator
	self.activity.hidden = YES;
	
	// reset the progress bar
	self.progressView.progress = 0.0;
	
	// set the progress bar to one suitable for downloading the images
	self.progressView.progressViewStyle = UIProgressViewStyleBar;
	
	// reset the title on the date buttons
	self.startDateSetButton.titleLabel.text = @"Click to Set";
	self.endDateSetButton.titleLabel.text = @"Click to Set";
	
	// the go button will be disabled until the dates have been set
	self.goButton.enabled = NO;

	// set defaults
	startDate = nil;
	endDate = nil;
	self.fpsField.text = @"9.0";
	fps = 9.0;
	
	// get the main view controller
	SMMainViewController* controller = (SMMainViewController*)self.delegate;
	
	// steal the date control view and date picker from the main view controller
	self.datePicker = controller.datePicker;
	self.dateControlView = controller.dateControlView;
	[self.dateControlView removeFromSuperview];
	[self.view addSubview:self.dateControlView];
	self.hideDateControlButton = controller.hideDateControlButton;
	[self.hideDateControlButton removeTarget:controller action:@selector(hideDateControl) forControlEvents:UIControlEventTouchUpInside];
	[self.hideDateControlButton addTarget:self action:@selector(hideDateControl) forControlEvents:UIControlEventTouchUpInside];
	
	// but hide it
	self.dateControlView.alpha = 0.0;
	
	// state variables used to know which date has been set when the date control view is hidden
	settingStartDate = NO;
	settingEndDate = NO;
	
	// get the app delegate
	SMAppDelegate* appDelegate = (SMAppDelegate*)[[UIApplication sharedApplication] delegate];
	
	// steal the animation data source.
	// it will no longer report to the default view of the main view
	// but now to the movie creator
	animationDataSource = appDelegate.animationDataSource;
	animationDataSource.delegate = self;
	animationDataSource.anim_delegate = self;
	[animationDataSource cancel];
	[animationDataSource flush];
	[animationDataSource setValue:type forParameterKey:@"type"];
	
	// state variable used to know when the animation properties have changed
	// and new content needs to be downloaded
	animationNeedsUpdate = YES;
	
	// state variable used to know when the images are downloading
	isLoading = NO;
}
- (void)showDateControl {
	// basically the same animation as in the main view controller
	
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
	// basically the same animation as in the main view controller
	
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
	// the 'type' is the tag for the image wavelength to be used
	type = aString;
}
- (IBAction)back {
	// give back the date control view
	[self.dateControlView removeFromSuperview];
	SMMainViewController* controller = (SMMainViewController*)self.delegate;
	[controller.view addSubview:self.dateControlView];
	[self.hideDateControlButton removeTarget:self action:@selector(hideDateControl) forControlEvents:UIControlEventTouchUpInside];
	[self.hideDateControlButton addTarget:controller action:@selector(hideDateControl) forControlEvents:UIControlEventTouchUpInside];
	
	// give back the animation data source
	[animationDataSource setValue:@"" forParameterKey:@"startdate"];
	[animationDataSource setValue:@"" forParameterKey:@"enddate"];
	[animationDataSource setValue:@"" forParameterKey:@"type"];
	animationDataSource.delegate = controller;
	animationDataSource.anim_delegate = controller;
	
	// return to the main view
	[self.delegate flipsideViewControllerDidFinish:self];
}
- (IBAction)setStartDate {
	// the start date must not be allowed to be _after_ the end date
	if(endDate != nil) {
		// set the max date to the end date
		self.datePicker.maximumDate = endDate;
		
		// set the minimum date to 1/1/1996
		self.datePicker.minimumDate = [NSDate dateWithTimeIntervalSince1970:820454400];
		
		// set the default value to be either the current start date (if it is set)
		// or the current end date, to allow users to go back from that point
		self.datePicker.date = (startDate == nil) ? endDate : startDate;
	}
	// otherwise set the maximum date to be the current date
	else {
		// max date is the current date
		self.datePicker.maximumDate = [NSDate dateWithTimeIntervalSinceNow:0];
		
		// minimum date is 1/1/1996
		self.datePicker.minimumDate = [NSDate dateWithTimeIntervalSince1970:820454400];
		self.datePicker.date = self.datePicker.maximumDate;
	}
	
	// set the state for this date picker
	settingStartDate = YES;
	
	// show the date control
	[self showDateControl];
}
- (IBAction)setEndDate {
	// the end date must not be allowed to be _before_ the start date
	if(startDate != nil) {
		// set the maximum date to the current date
		self.datePicker.maximumDate = [NSDate dateWithTimeIntervalSinceNow:0];
		
		// set the minimum date to the start date
		self.datePicker.minimumDate = startDate;
		
		// set the default date to be the current end date if it is set
		// or the current start date
		self.datePicker.date = (endDate == nil) ? startDate : endDate;
	}
	// otherwise, no particular boundries
	else {
		// max date is current date
		self.datePicker.maximumDate = [NSDate dateWithTimeIntervalSinceNow:0];
		
		// min date is 1/1/1996
		self.datePicker.minimumDate = [NSDate dateWithTimeIntervalSince1970:820454400];
		
		// default date is current date
		self.datePicker.date = self.datePicker.maximumDate;
	}
	// set state variable
	settingEndDate = YES;
	
	// show the control
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
}
- (void)animation:(SMAnimationDataSource*)sender didProgressWithCount:(int)count ofTotal:(int)total {
	self.progressView.progress = (float)count / (float)total;
}
- (void)didReceiveMemoryWarning {
	if(isLoading) {
		[animationDataSource cancel];
		[animationDataSource flush];
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
		UIAlertView *alert =
		[[UIAlertView alloc] initWithTitle: @"Memory Warning"
								   message: @"Your device does not have enough memory to download so many frames. Try sticking to ranges of 2-3 months or less."
								  delegate: self
						 cancelButtonTitle: @"OK"
						 otherButtonTitles: nil];
		[alert show];
		[alert release];
	}
}
- (void)dealloc {
	[animationDataSource cancel];
	[animationDataSource flush];
	[super dealloc];
}
@end
