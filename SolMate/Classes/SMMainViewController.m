//
//  SMMainViewController.m
//  UtilityTest
//
//  Created by Simon Free on 08/06/2010.
//  Copyright SolarMonitor.org 2010. All rights reserved.
//

#import "SMMainViewController.h"
#import "SMSmallARListCell.h"
#import "SMAppDelegate.h"
#import "SMTabbedViewController.h"
#import "SMImageDetailViewController.h"
#import "SMMovieCreatorViewController.h"
#import "SMDateControlViewController.h"
#import "Reachability.h"
#import "SMForecastViewController.h"
#import <CoreGraphics/CoreGraphics.h>
#import <QuartzCore/QuartzCore.h>
#import <UIKit/UIViewController.h>

#define DARK_BACKGROUND  [UIColor colorWithRed:37.0/255.0 green:37.0/255.0 blue:37.0/255.0 alpha:1.0]
#define LIGHT_BACKGROUND [UIColor colorWithRed:31.0/255.0 green:31.0/255.0 blue:31.0/255.0 alpha:1.0]



@implementation SMMainViewController

@synthesize tabBar=_tabBar,
			defaultImageTime=_defaultImageTime,
			defaultImageType=_defaultImageType,
			defaultImageView=_defaultImageView,
			smallARList=_smallARList,
			activityIndicator=_activityIndicator,
			tmpCell=_tmpCell,
			tabContentView=_tabContentView,
			tabbedViewController=_tabbedViewController,
			dateControlView=_dateControlView,
			datePicker=_datePicker,
			progressView=_progressView,
			hideDateControlButton=_hideDateControlButton,
			toggleAnimationButton=_toggleAnimationButton;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil {
    if ((self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil])) {
        
    }
    return self;
}

// Implement viewDidLoad to do additional setup after loading the view, typically from a nib.
- (void)viewDidLoad {
	[super viewDidLoad];
	
	// hide the active region list until it is loaded
	self.smallARList.hidden = YES;
	
	// set the properties of the active region list
	self.smallARList.rowHeight = 14.0;
    self.smallARList.backgroundColor = [UIColor clearColor];
	self.smallARList.layer.cornerRadius = 4.0;
    self.smallARList.separatorStyle = UITableViewCellSeparatorStyleNone;
	
	// add the date control view to the main view and hide it
	[self.view addSubview:self.dateControlView];
	self.dateControlView.hidden = YES;
	
	// set the default values for the date control view
	self.datePicker.maximumDate = [NSDate dateWithTimeIntervalSinceNow:0.0];
	self.datePicker.date = self.datePicker.maximumDate;
	
	// set the delegate of the image data source to the tabbed view controller and update it
	((SMAppDelegate*)[UIApplication sharedApplication].delegate).imagesDataSource.delegate = self.tabbedViewController;
	[((SMAppDelegate*)[UIApplication sharedApplication].delegate).imagesDataSource update];
	
	// the same for the forecast data source
	((SMAppDelegate*)[UIApplication sharedApplication].delegate).forecastDataSource.delegate = self.tabbedViewController;
	[((SMAppDelegate*)[UIApplication sharedApplication].delegate).forecastDataSource update];
	
	// default value for the default view animation
	animationLoaded = NO;
	[self.toggleAnimationButton setHidden:YES];
	
	// a cache holding the pre-masked images for the default view animation,
	// so those stored in the animation data source can be freed up
	maskedImagesCache = nil;
}



- (void)flipsideViewControllerDidFinish:(SMFlipsideViewController *)controller {
    // boilerplate code for a flipside view
	[self dismissModalViewControllerAnimated:YES];
}


- (IBAction)showInfo {    
	// load the controller for the preferences panel
	SMFlipsideViewController *controller = [[SMFlipsideViewController alloc] initWithNibName:@"FlipsideView" bundle:nil];
	
	// set the delegate for the preferences panel controller
	controller.delegate = self;
	
	// set the transition animation
	controller.modalTransitionStyle = UIModalTransitionStyleFlipHorizontal;
	[self presentModalViewController:controller animated:YES];
	
	// we don't own it anymore
	[controller release];
}

- (IBAction)showDateControl {
	// unhide the date control view
	self.dateControlView.hidden = NO;
	
	// bring it to the front of all other views
	[self.view bringSubviewToFront:self.dateControlView];
	
	// set its frame to be below the screen
	self.dateControlView.frame = CGRectMake(
											0.0,
											[[UIScreen mainScreen] bounds].size.height,
											self.dateControlView.frame.size.width,
											self.dateControlView.frame.size.height);
	
	// set its alpha value to invisible
	self.dateControlView.alpha = 0.0;
	
	// begin animations on the main view
	[UIView beginAnimations:nil context:nil];
	
	// set the duration
	[UIView setAnimationDuration:0.4];
	
	// in this animation, the frame of the date control view will
	// be brought up to its normal position
	self.dateControlView.frame = CGRectMake(
											0.0,
											0.0,
											self.dateControlView.frame.size.width,
											self.dateControlView.frame.size.height);
	
	// and its alpha value will reach fully opaque
	self.dateControlView.alpha = 1.0;
	
	// save animations and run them
	[UIView commitAnimations];
}
- (IBAction)hideDateControl {
	// begin animations on the main view
	[UIView beginAnimations:nil context:nil];
	
	// set the duration
	[UIView setAnimationDuration:0.4];
	
	// in this animation the frame of the date control view will
	// be brough back down below the screen
	self.dateControlView.frame = CGRectMake(
											0,
											[[UIScreen mainScreen] bounds].size.height,
											self.dateControlView.frame.size.width,
											self.dateControlView.frame.size.height);
	
	// and it will turn completely transparent
	self.dateControlView.alpha = 0.0;
	
	// save animations and run them
	[UIView commitAnimations];
	
	// change the working date of the application to reflect the updated
	// value from the date control view
	SMAppDelegate* appDel = (SMAppDelegate*)[[UIApplication sharedApplication] delegate];
	appDel.workingDate = [self.datePicker date];
	
}
- (IBAction)dateControlGotoToday {
	// set the date on the date picker to today
	[self.datePicker setDate:[NSDate dateWithTimeIntervalSinceNow:0.0]];
}
- (IBAction)dateControlBackRotation {
	// set the date on the date picker to go backwards 27 days
	// negative (27 days x 24 hours x 60 minutes x 60 seconds)
	NSDate* pickerDate = [self.datePicker date];
	NSDate* newDate = [pickerDate dateByAddingTimeInterval:0.0-(27.0*24*60*60)];
	[self.datePicker setDate:newDate];
}
- (IBAction)dateControlBackWeek {
	// set the date on the date picker to go backwards 1 week
	// negative (7 days x 24 hours x 60 minutex 60 seconds)
	NSDate* pickerDate = [self.datePicker date];
	NSDate* newDate = [pickerDate dateByAddingTimeInterval:0.0-(7.0*24*60*60)];
	[self.datePicker setDate:newDate];
}
- (IBAction)dateControlForwardWeek {
	// set the date on the date picker to go forward 1 week
	// (7 days x 24 hours x 60 minutex 60 seconds)
	NSDate* pickerDate = [self.datePicker date];
	NSDate* newDate = [pickerDate dateByAddingTimeInterval:(7.0*24*60*60)];
	[self.datePicker setDate:([newDate compare:self.datePicker.maximumDate] == NSOrderedDescending) ? self.datePicker.maximumDate : newDate];
}
- (IBAction)dateControlForwardRotation {
	// set the date on the date picker to go forward 27 days
	// (27 days x 24 hours x 60 minutex 60 seconds)
	NSDate* pickerDate = [self.datePicker date];
	NSDate* newDate = [pickerDate dateByAddingTimeInterval:(27.0*24*60*60)];
	[self.datePicker setDate:([newDate compare:self.datePicker.maximumDate] == NSOrderedDescending) ? self.datePicker.maximumDate : newDate];
}

- (IBAction)toggleAnimation {
	// is the default animation still loading from the launch of the app?
	if([[self.toggleAnimationButton titleForState:UIControlStateNormal] isEqualToString:@"Stop"]
	   && animationLoaded == NO) {
		// get the application delegate
		SMAppDelegate* appDel = (SMAppDelegate*)[[UIApplication sharedApplication] delegate];
		
		// cancel the animation data source
		[appDel.animationDataSource cancel];
		
		// change the title of the Stop button to Play so it can restart the loading/animation
		[self.toggleAnimationButton setTitle:@"Play" forState:UIControlStateNormal];
		[self.toggleAnimationButton setTitle:@"Play" forState:UIControlStateHighlighted];
		[self.toggleAnimationButton setTitle:@"Play" forState:UIControlStateSelected];
		
		// this message causes the image data source to set the default image view to a static image
		// FIXME: race condition????
		[appDel.imagesDataSource imageLoaderDidComplete:nil];
	}
	// is the default animation loaded and running?
	else if([self.defaultImageView isAnimating]) {
		// set the static image to the last one in the animation frames
		NSArray* images = [self.defaultImageView animationImages];
		[self.defaultImageView setImage:[images objectAtIndex:[images count]-1]];
		
		// stop animating
		[self.defaultImageView stopAnimating];
		[self.defaultImageView setAnimationImages:nil];
		
		// change the play/stop button
		[self.toggleAnimationButton setTitle:@"Play" forState:UIControlStateNormal];
		[self.toggleAnimationButton setTitle:@"Play" forState:UIControlStateHighlighted];
		[self.toggleAnimationButton setTitle:@"Play" forState:UIControlStateSelected];
	}
	// or is the animation stopped?
	else {
		if(animationLoaded) {
			// the animation is loaded, just stopped
			// start it playing again from the masked images cache
			[self animationDidFinishLoading:nil];
		} else {
			// the animation has been stopped before it finished loading
			// so restart the animation data source to load the frames
			SMAppDelegate* appDel = (SMAppDelegate*)[[UIApplication sharedApplication] delegate];
			[appDel.animationDataSource preloadImages];
			
			// set the progress bar running
			self.progressView.hidden = NO;
			self.progressView.progress = 0.0;
			
			// change the play/stop button
			[self.toggleAnimationButton setTitle:@"Stop" forState:UIControlStateNormal];
			[self.toggleAnimationButton setTitle:@"Stop" forState:UIControlStateHighlighted];
			[self.toggleAnimationButton setTitle:@"Stop" forState:UIControlStateSelected];
		}
	}
}

- (void)showImageDetailViewWithData:(NSDictionary* )dict {
	// the user has pressed on one of the image types in the table
	
	// load the image detail view controller
	SMImageDetailViewController* controller = [[SMImageDetailViewController alloc] initWithNibName:@"SMImageDetailView" bundle:nil];
	
	// set its delegate
	controller.delegate = self;
	
	// tell it which image to load
	[controller showImageWithData:dict];
	
	// set the transition animation
	controller.modalTransitionStyle = UIModalTransitionStyleCoverVertical;
	[self presentModalViewController:controller animated:YES];
	
	// we don't own it anymore
	[controller release];
}
- (void)showMovieCreatorForType:(NSString*)type {
	// the user has pressed on one of the types for the movie creator
	
	// load the movie creator controller
	SMMovieCreatorViewController* controller = [[SMMovieCreatorViewController alloc] initWithNibName:@"SMMovieCreatorView" bundle:nil];
	
	// set its delegate
	controller.delegate = self;
	
	// tell it which wavelength type to use
	controller.type = type;
	
	// set the transition animation
	controller.modalTransitionStyle = UIModalTransitionStyleFlipHorizontal;
	[self presentModalViewController:controller animated:YES];
	
	// we don't own it anymore
	[controller release];
}
- (void)showForecastViewWithData:(NSDictionary*)dict {
	// the user has pressed one of the forecasts in the forecast table
	
	// load the controller
	SMForecastViewController* controller = [[SMForecastViewController alloc] initWithNibName:@"SMForecastView" bundle:nil];
	
	// set the delegate
	controller.delegate = self;
	
	// give it the data
	[controller showForecastWithData:dict];
	
	// set the transition animation
	controller.modalTransitionStyle = UIModalTransitionStyleFlipHorizontal;
	[self presentModalViewController:controller animated:YES];
	
	// we don't own it anymore
	[controller release];
}

- (void)didReceiveMemoryWarning {
	// Releases the view if it doesn't have a superview.
    [super didReceiveMemoryWarning];
	// Release any cached data, images, etc. that aren't in use.
}


- (void)viewDidUnload {
	// Release any retained subviews of the main view.
	// e.g. self.myOutlet = nil;
}


/*
// Override to allow orientations other than the default portrait orientation.
- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation {
	// Return YES for supported orientations.
	return (interfaceOrientation == UIInterfaceOrientationPortrait);
}
*/


- (void)dealloc {
    [super dealloc];
}

- (void)updateDefaultViewWithDictionary:(NSDictionary*)dict {
	// either called when the image loader has loaded all its images and is
	// ready to display a static image (usually happens first before the animation
	// has loaded on a slow connection), or when the animation has finished loading
	// its frames
	
	// get the app delegate
	SMAppDelegate* appDelegate = (SMAppDelegate*)[[UIApplication sharedApplication] delegate];
	
	// either the animation has loaded and will play, or it will load soon, or it won't load
	// due to the connection type. therefore show the play/stop button to perform the
	// action to toggle the animation on or off, loading it if required
	[self.toggleAnimationButton setHidden:NO];
	
	// if the imageArray key does not exist in the dictionary given to this method
	// then just a static image from the imageloader has been loaded and should be displayed
	if ([dict objectForKey:@"imageArray"] == nil) {
		// only do this if the animation is not already running
		if(![self.defaultImageView isAnimating]) {
			// set the play/stop button to allow the animation to be loaded in future
			[self.toggleAnimationButton setTitle:@"Play" forState:UIControlStateNormal];
			[self.toggleAnimationButton setTitle:@"Play" forState:UIControlStateHighlighted];
			[self.toggleAnimationButton setTitle:@"Play" forState:UIControlStateSelected];
			
			// set the static image
			self.defaultImageView.image = [appDelegate maskImage:[dict objectForKey:@"image"] withMask:[UIImage imageNamed:@"mask.png"]];
			
			// set the type and time text
			self.defaultImageType.text = [dict objectForKey:@"type"];
			self.defaultImageTime.text = [dict objectForKey:@"time"];
			
		}				
	}
	// otherwise this means the frames from the animation are loaded
	else {
		// this might be called to restart the animation, so there might be images in the cache
		if(maskedImagesCache == nil) {
			// ther are no images in the cache, so take the images out of the imageArray key
			NSMutableArray *imagesArray = [NSMutableArray arrayWithCapacity:[[dict objectForKey:@"imageArray"] count]];
			
			// mask each image with the semi-transparent background
			for (UIImage* img in [dict objectForKey:@"imageArray"]) {
				[imagesArray addObject:[appDelegate maskImage:img withMask:[UIImage imageNamed:@"mask.png"]]];
			}
			
			// set the animation frames
			self.defaultImageView.animationImages = imagesArray;
			
			// save these masked images in the cache
			maskedImagesCache = imagesArray;
		} else {
			// the cache exists, so just set those images
			self.defaultImageView.animationImages = maskedImagesCache;	
		}
		
		// set the animation duration
		self.defaultImageView.animationDuration = 3.0;
		
		// infinitely repeat
		self.defaultImageView.animationRepeatCount = 0;
		
		// start the animation
		[self.defaultImageView startAnimating];
		
		// set the default type/time text
		self.defaultImageType.text = [dict objectForKey:@"type"];
		self.defaultImageTime.text = [dict objectForKey:@"time"];
		
		// set the play/stop button for stopping the animation in future
		[self.toggleAnimationButton setTitle:@"Stop" forState:UIControlStateNormal];
		[self.toggleAnimationButton setTitle:@"Stop" forState:UIControlStateHighlighted];
		[self.toggleAnimationButton setTitle:@"Stop" forState:UIControlStateSelected];
		
		// the animation is now loaded
		animationLoaded = YES;
		
		// flush the raw (unmasked) images from the animation data source
		[appDelegate.animationDataSource flush];
	}
}

#pragma mark JSONDataSourceDelegate methods

- (void)dataSourceDidStartLoading:(JSONDataSource*)ds {
	// get the app delegate
	SMAppDelegate* appDelegate = (SMAppDelegate *)[[UIApplication sharedApplication] delegate];
	
	// handle the case where the data source in question is the active region data source
	if(ds == appDelegate.activeRegionDataSource) {
		NSLog(@"data source start loading");
		
		// make sure the list is hidden
		self.smallARList.hidden = YES;
		
		// start the activity indicator
		[self.activityIndicator startAnimating];
		self.activityIndicator.hidden = NO;
	}
}
- (void)dataSourceDidFinishLoading:(JSONDataSource*)ds {
	// get the app delegate
	SMAppDelegate* appDelegate = (SMAppDelegate *)[[UIApplication sharedApplication] delegate];
	
	// handle the case where the current data source is the active region data source
	if(ds == appDelegate.activeRegionDataSource) {
		// unhide the list
		self.smallARList.hidden = NO;
		
		// stop the activity indicator
		[self.activityIndicator stopAnimating];
		self.activityIndicator.hidden = YES;
		
		// reload the table so it can use the data loaded in the data source
		[self.smallARList reloadData];
	}
	// handle the case where the data source in question is the animation data source
	else if(ds == appDelegate.animationDataSource) {
		// check to see what type of network connection the device has
		Reachability* reach = [Reachability reachabilityForInternetConnection];
		NetworkStatus status = [reach currentReachabilityStatus];
		
		// if the network connection on the device is a wifi connection
		if(status == ReachableViaWiFi) {
			// then load the animation for the default image view
			[appDelegate.animationDataSource preloadImages];
			
			// set the progress bar
			self.progressView.hidden = NO;
			self.progressView.progress = 0.0;
		}
		
		// the animation will not be loadoed on a 3G connection because this
		// will usually be way to slow to facilitate such things in any
		// acceptable time frame
	}
}

#pragma mark SMAnimationDataSourceDelegate methods
- (void)animation:(SMAnimationDataSource*)sender didProgressWithCount:(int)count ofTotal:(int)total {
	// update the progress bar for the animation loading with the current value
	double progress = (double)count / (double)total;
	self.progressView.progress = progress;
}

- (void)animationDidFinishLoading:(SMAnimationDataSource*)sender {
	// the frames for the animation are finished loading and available to use
	
	// get the app delegate
	SMAppDelegate* appDelegate = (SMAppDelegate *)[[UIApplication sharedApplication] delegate];
	
	// get the default type for the animation
	NSString* key = @"bbso_halph";
	
	// pull the metadata for this type from the images data source
	NSDictionary* dict;
	for (dict in [appDelegate.imagesDataSource thumbnails]) {
		if([[dict objectForKey:@"type"] isEqualToString:key])
			break;
	}
	
	// this is used in -objectsForKeys:notFoundMarker: but is nevver used because we know the value will be
	// there
	UIImage* marker = [[appDelegate.animationDataSource.preloadedImages allValues] objectAtIndex:0];
	
	// send the message to start displaying the animation frames
	// the dictionary sent in this contains an array of images
	// sorted by the order of frames
	[self updateDefaultViewWithDictionary:[NSDictionary dictionaryWithObjectsAndKeys:
												 [appDelegate.animationDataSource.preloadedImages
														objectsForKeys:[[appDelegate.animationDataSource.preloadedImages
																		allKeys] sortedArrayUsingSelector:@selector(compareNumerically:)]
														notFoundMarker:marker],@"imageArray",
												 key,@"type",
												 [dict objectForKey:@"time"],@"time",
												 nil]
	 ];
	// hide the progress bar
	self.progressView.hidden = YES;
}

#pragma mark UITableView data source methods

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
	// boilerplate code
    return 1;
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
	// this method returns the number of rows to be displayed in the active region table
	// depending on whether or not the datasource has data yet
	
	// get the app delegate
	SMAppDelegate* appDelegate = (SMAppDelegate *)([UIApplication sharedApplication].delegate);
	
	// pretty straightforward
	if(appDelegate.activeRegionDataSource.hasData) {
		return [[appDelegate.activeRegionDataSource activeRegions] count];
	}
    else {
		return 0;
	}

}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
	// this is used for queueing and dequeueing table cells for reuse
    static NSString *CellIdentifier = @"SmallARListCell";

	// get the app delegate
	SMAppDelegate* appDelegate = (SMAppDelegate *)([UIApplication sharedApplication].delegate);
	
	// get the list of active regions from the data source, which is accessed through the app delegate
	NSArray* data = [appDelegate.activeRegionDataSource activeRegions];
    
	// try to dequeue a cell for reuse
	SMSmallARListCell* cell = (SMSmallARListCell *)[tableView dequeueReusableCellWithIdentifier:CellIdentifier];
	
	// if there is no reusable cell, create a new one
	if(cell == nil) {
		// load the interface definition
		[[NSBundle mainBundle] loadNibNamed:@"SMSmallARListCell" owner:self options:nil];
		
		// copy the cell from the ivar that will be set
        cell = _tmpCell;
		
		// reset the ivar
        self.tmpCell = nil;
	}
    
	// Display dark and light background in alternate rows -- see tableView:willDisplayCell:forRowAtIndexPath:.
	cell.backgroundColor = (indexPath.row % 2 == 0) ? DARK_BACKGROUND : LIGHT_BACKGROUND;	
	
	// Configure the data for the cell.
	
	// get the index of the active regions array for this index
    NSDictionary *dataItem = [data objectAtIndex:indexPath.row];
	
	// get all the data needed
	NSNumber* noaaNumber = [dataItem objectForKey:@"number"];
	NSString* hale = [dataItem objectForKey:@"hale1"];
	NSString* mcintosh = [dataItem objectForKey:@"mcintosh"];
	
	// create the main label
	NSString* label = [NSString stringWithFormat:@"NOAA #%i  %@  %@",[noaaNumber intValue],hale,mcintosh];
	
	// apply the label
    [cell.label setText:label];
	
	//this table cell has no accessory view
    cell.accessoryType = UITableViewCellAccessoryNone;
	
    return cell;
}

- (void)tableView:(UITableView *)tableView willDisplayCell:(UITableViewCell *)cell forRowAtIndexPath:(NSIndexPath *)indexPath
{
    
}

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
	// these cells go nowhere
    [tableView deselectRowAtIndexPath:indexPath animated:YES];
}


@end
