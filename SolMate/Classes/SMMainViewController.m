//
//  SMMainViewController.m
//  UtilityTest
//
//  Created by Simon Free on 08/06/2010.
//  Copyright __MyCompanyName__ 2010. All rights reserved.
//

#import "SMMainViewController.h"
#import "SMSmallARListCell.h"
#import "SMAppDelegate.h"
#import "SMTabbedViewController.h"
#import "SMImageDetailViewController.h"
#import "SMMovieCreatorViewController.h"
#import "SMDateControlViewController.h"
#import "Reachability.h"
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
	self.defaultImageView.image = [(SMAppDelegate*)[[UIApplication sharedApplication] delegate] maskImage:self.defaultImageView.image withMask:[UIImage imageNamed:@"mask.png"]];
	self.defaultImageView.backgroundColor = [UIColor clearColor];
	self.smallARList.hidden = YES;
	
	self.smallARList.rowHeight = 14.0;
    self.smallARList.backgroundColor = [UIColor clearColor];
	self.smallARList.layer.cornerRadius = 4.0;
    self.smallARList.separatorStyle = UITableViewCellSeparatorStyleNone;
	
	[self.view addSubview:self.dateControlView];
	self.dateControlView.hidden = YES;
	
	self.datePicker.maximumDate = [NSDate dateWithTimeIntervalSinceNow:0.0];
	self.datePicker.date = self.datePicker.maximumDate;
	
	((SMAppDelegate*)[UIApplication sharedApplication].delegate).imagesDataSource.delegate = self.tabbedViewController;
	[((SMAppDelegate*)[UIApplication sharedApplication].delegate).imagesDataSource update];
	
	animationLoaded = NO;
}



- (void)flipsideViewControllerDidFinish:(SMFlipsideViewController *)controller {
    
	[self dismissModalViewControllerAnimated:YES];
}


- (IBAction)showInfo {    
	
	SMFlipsideViewController *controller = [[SMFlipsideViewController alloc] initWithNibName:@"FlipsideView" bundle:nil];
	controller.delegate = self;
	
	controller.modalTransitionStyle = UIModalTransitionStyleFlipHorizontal;
	[self presentModalViewController:controller animated:YES];
	
	[controller release];
}

- (IBAction)showDateControl {
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
- (IBAction)hideDateControl {
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
	SMAppDelegate* appDel = (SMAppDelegate*)[[UIApplication sharedApplication] delegate];
	appDel.workingDate = [self.datePicker date];
	
}
- (IBAction)dateControlGotoToday {
	[self.datePicker setDate:[NSDate dateWithTimeIntervalSinceNow:0.0]];
}
- (IBAction)dateControlBackRotation {
	NSDate* pickerDate = [self.datePicker date];
	NSDate* newDate = [pickerDate dateByAddingTimeInterval:0.0-(27.0*24*60*60)];
	[self.datePicker setDate:newDate];
}
- (IBAction)dateControlBackWeek {
	NSDate* pickerDate = [self.datePicker date];
	NSDate* newDate = [pickerDate dateByAddingTimeInterval:0.0-(7.0*24*60*60)];
	[self.datePicker setDate:newDate];
}
- (IBAction)dateControlForwardWeek {
	NSDate* pickerDate = [self.datePicker date];
	NSDate* newDate = [pickerDate dateByAddingTimeInterval:(7.0*24*60*60)];
	[self.datePicker setDate:([newDate compare:self.datePicker.maximumDate] == NSOrderedDescending) ? self.datePicker.maximumDate : newDate];
}
- (IBAction)dateControlForwardRotation {
	NSDate* pickerDate = [self.datePicker date];
	NSDate* newDate = [pickerDate dateByAddingTimeInterval:(27.0*24*60*60)];
	[self.datePicker setDate:([newDate compare:self.datePicker.maximumDate] == NSOrderedDescending) ? self.datePicker.maximumDate : newDate];
}

- (IBAction)toggleAnimation {
	if([[self.toggleAnimationButton titleForState:UIControlStateNormal] isEqualToString:@"Stop"]
	   && isAnimating == NO) {
		SMAppDelegate* appDel = (SMAppDelegate*)[[UIApplication sharedApplication] delegate];
		[appDel.animationDataSource cancel];
		[self.toggleAnimationButton setTitle:@"Play" forState:UIControlStateNormal];
		[self.toggleAnimationButton setTitle:@"Play" forState:UIControlStateHighlighted];
		[self.toggleAnimationButton setTitle:@"Play" forState:UIControlStateSelected];
		
	}
	if([self.defaultImageView isAnimating]) {
		NSArray* images = [self.defaultImageView animationImages]
		[self.defaultImageView setImage:[images objectAtIndex:[images count]-1]];
		[self.toggleAnimationButton setTitle:@"Play" forState:UIControlStateNormal];
		[self.toggleAnimationButton setTitle:@"Play" forState:UIControlStateHighlighted];
		[self.toggleAnimationButton setTitle:@"Play" forState:UIControlStateSelected];
	} else {
		if(animationLoaded) {
			
		}
	}
}

- (void)showImageDetailViewWithData:(NSDictionary* )dict {
	SMImageDetailViewController* controller = [[SMImageDetailViewController alloc] initWithNibName:@"SMImageDetailView" bundle:nil];
	controller.delegate = self;
	[controller showImageWithData:dict];
	controller.modalTransitionStyle = UIModalTransitionStyleCoverVertical;
	[self presentModalViewController:controller animated:YES];
	[controller release];
}
- (void)showMovieCreatorForType:(NSString*)type {
	SMMovieCreatorViewController* controller = [[SMMovieCreatorViewController alloc] initWithNibName:@"SMMovieCreatorView" bundle:nil];
	controller.delegate = self;
	controller.type = type;
	controller.modalTransitionStyle = UIModalTransitionStyleFlipHorizontal;
	[self presentModalViewController:controller animated:YES];
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
	SMAppDelegate* appDelegate = (SMAppDelegate*)[[UIApplication sharedApplication] delegate];
	if ([dict objectForKey:@"imageArray"] == nil) {
		if(![self.defaultImageView isAnimating]) {
			[self.defaultImageView stopAnimating];
			[self.toggleAnimationButton setTitle:@"Play" forState:UIControlStateNormal];
			[self.toggleAnimationButton setTitle:@"Play" forState:UIControlStateHighlighted];
			[self.toggleAnimationButton setTitle:@"Play" forState:UIControlStateSelected];
			self.defaultImageView.image = [appDelegate maskImage:[dict objectForKey:@"image"] withMask:[UIImage imageNamed:@"mask.png"]];
			self.defaultImageType.text = [dict objectForKey:@"type"];
			self.defaultImageTime.text = [dict objectForKey:@"time"];
			
		}				
	} else {
		NSMutableArray *imagesArray = [NSMutableArray arrayWithCapacity:[[dict objectForKey:@"imageArray"] count]];
		for (UIImage* img in [dict objectForKey:@"imageArray"]) {
			[imagesArray addObject:[appDelegate maskImage:img withMask:[UIImage imageNamed:@"mask.png"]]];
		}
		self.defaultImageView.animationImages = imagesArray;
		self.defaultImageView.animationDuration = 3.0;
		self.defaultImageView.animationRepeatCount = 0;
		[self.defaultImageView startAnimating];
		self.defaultImageType.text = [dict objectForKey:@"type"];
		self.defaultImageTime.text = [dict objectForKey:@"time"];
		[self.toggleAnimationButton setTitle:@"Stop" forState:UIControlStateNormal];
		[self.toggleAnimationButton setTitle:@"Stop" forState:UIControlStateHighlighted];
		[self.toggleAnimationButton setTitle:@"Stop" forState:UIControlStateSelected];
		animationLoaded = YES;
	}
}

#pragma mark JSONDataSourceDelegate methods

- (void)dataSourceDidStartLoading:(JSONDataSource*)ds {
	SMAppDelegate* appDelegate = (SMAppDelegate *)[[UIApplication sharedApplication] delegate];
	if(ds == appDelegate.activeRegionDataSource) {
		NSLog(@"data source start loading");
		self.smallARList.hidden = YES;
		[self.activityIndicator startAnimating];
		self.activityIndicator.hidden = NO;
	}
}
- (void)dataSourceDidFinishLoading:(JSONDataSource*)ds {
	SMAppDelegate* appDelegate = (SMAppDelegate *)[[UIApplication sharedApplication] delegate];
	if(ds == appDelegate.activeRegionDataSource) {
		self.smallARList.hidden = NO;
		[self.activityIndicator stopAnimating];
		self.activityIndicator.hidden = YES;
		[self.smallARList reloadData];
	} else if(ds == appDelegate.animationDataSource) {
		Reachability* reach = [Reachability reachabilityForInternetConnection];
		NetworkStatus status = [reach currentReachabilityStatus];
		if(status == ReachableViaWiFi) {
			[appDelegate.animationDataSource preloadImages];
			self.progressView.hidden = NO;
			self.progressView.progress = 0.0;
		}
			
	}
}

#pragma mark SMAnimationDataSourceDelegate methods
- (void)animation:(SMAnimationDataSource*)sender didProgressWithCount:(int)count ofTotal:(int)total {
	double progress = (double)count / (double)total;
	self.progressView.progress = progress;
}

- (void)animationDidFinishLoading:(SMAnimationDataSource*)sender {
	SMAppDelegate* appDelegate = (SMAppDelegate *)[[UIApplication sharedApplication] delegate];
	NSString* key = @"bbso_halph";
	NSDictionary* dict;
	for (dict in [appDelegate.imagesDataSource thumbnails]) {
		if([[dict objectForKey:@"type"] isEqualToString:key])
			break;
	}
	UIImage* marker = [[appDelegate.animationDataSource.preloadedImages allValues] objectAtIndex:0];
	[self updateDefaultViewWithDictionary:[NSDictionary dictionaryWithObjectsAndKeys:
												 [appDelegate.animationDataSource.preloadedImages
														objectsForKeys:[[appDelegate.animationDataSource.preloadedImages
																		allKeys] sortedArrayUsingSelector:@selector(compareNumerically:)]
														notFoundMarker:marker],@"imageArray",
												 key,@"type",
												 [dict objectForKey:@"time"],@"time",
												 nil]
	 ];
	self.progressView.hidden = YES;
}

#pragma mark UITableView data source methods

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
    return 1;
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
	SMAppDelegate* appDelegate = (SMAppDelegate *)([UIApplication sharedApplication].delegate);
	if(appDelegate.activeRegionDataSource.hasData) {
		return [[appDelegate.activeRegionDataSource activeRegions] count];
	}
    else {
		return 0;
	}

}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    static NSString *CellIdentifier = @"SmallARListCell";
	
	SMAppDelegate* appDelegate = (SMAppDelegate *)([UIApplication sharedApplication].delegate);
	NSArray* data = [appDelegate.activeRegionDataSource activeRegions];
    
	SMSmallARListCell* cell = (SMSmallARListCell *)[tableView dequeueReusableCellWithIdentifier:CellIdentifier];
	
	if(cell == nil) {
		[[NSBundle mainBundle] loadNibNamed:@"SMSmallARListCell" owner:self options:nil];
        cell = _tmpCell;
        self.tmpCell = nil;
	}
	
    //SMSmallARListCell* cell = [[[SMSmallARListCell alloc] initWithFrame:CGRectZero reuseIdentifier:CellIdentifier] autorelease];
    
	// Display dark and light background in alternate rows -- see tableView:willDisplayCell:forRowAtIndexPath:.
	cell.backgroundColor = (indexPath.row % 2 == 0) ? DARK_BACKGROUND : LIGHT_BACKGROUND;	
	// Configure the data for the cell.
	
    NSDictionary *dataItem = [data objectAtIndex:indexPath.row];
	NSNumber* noaaNumber = [dataItem objectForKey:@"number"];
	NSString* hale = [dataItem objectForKey:@"hale1"];
	NSString* mcintosh = [dataItem objectForKey:@"mcintosh"];
	NSString* label = [NSString stringWithFormat:@"NOAA #%i  %@  %@",[noaaNumber intValue],hale,mcintosh];
    [cell.label setText:label];
    cell.accessoryType = UITableViewCellAccessoryNone;
	
    return cell;
}

- (void)tableView:(UITableView *)tableView willDisplayCell:(UITableViewCell *)cell forRowAtIndexPath:(NSIndexPath *)indexPath
{
    
}

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    [tableView deselectRowAtIndexPath:indexPath animated:YES];
}


@end
