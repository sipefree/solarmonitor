//
//  SMTabbedViewController.m
//
//  Created by Simon Free on 10/06/2010.
//  Copyright 2010 SolarMonitor.org. All rights reserved.
//
#import <QuartzCore/QuartzCore.h>
#import "SMTabbedViewController.h"
#import "SMMainViewController.h"
#import "SMListCell.h"
#import "SMAppDelegate.h"

#define CELL_DARK_BACKGROUND  [UIColor colorWithRed:151.0/255.0 green:152.0/255.0 blue:155.0/255.0 alpha:1.0]
#define CELL_LIGHT_BACKGROUND [UIColor colorWithRed:172.0/255.0 green:173.0/255.0 blue:175.0/255.0 alpha:1.0]

@implementation SMTabbedViewController
@synthesize tmpCell;

- (void)awakeFromNib {
	// this class implements a tab view of its own
	// by storing the three views that it switches between
	// and the current active one
	
	// set the default active view
	activeView = imagesView;
	
	// and the default active button
	activeButton = imagesButton;
	
	// show the button as selected
	[activeButton setSelected:YES];
	
	// add all the tabs to be subviews of the entire view
	for(UIView* v in [NSArray arrayWithObjects:imagesView,moviesView,forecastView,nil]) {
		// add the subviews
		[controller.tabContentView addSubview:v];
		
		// set them hidden
		v.hidden = YES;
	}
	
	// but don't hide the active view
	activeView.hidden = NO;
	
	// configure all the table views
	for (UITableView* tableView in [NSArray arrayWithObjects:imagesTable,moviesTable,forecastTable,nil]) {
		// set the standard row height
		tableView.rowHeight = 73.0;
		
		// set the default background color
		tableView.backgroundColor = CELL_DARK_BACKGROUND;
		
		// set the style of line between each table cell
		tableView.separatorStyle = UITableViewCellSeparatorStyleNone;
	}
}
- (IBAction)showForecastView:(UIButton *)sender {
	// switch to the forecast view
	
	// only if the active view is not already the forecast view
	// this is so a redundant animation does not occur
	if(activeView != forecastView) {
		// create a transition animation
		CATransition *transition = [CATransition animation];
		
		// set the duration
		transition.duration = 0.4;
		
		// ease the transition with a sine wave or something
		transition.timingFunction = [CAMediaTimingFunction functionWithName:kCAMediaTimingFunctionEaseInEaseOut];
		
		// use a push transition
		transition.type = kCATransitionPush;
		
		// set the direction of the push
		transition.subtype = kCATransitionFromRight;
		
		// set the delegate of the transition
		transition.delegate = self;
		
		// Next add it to the containerView's layer. This will perform the transition based on how we change its contents.
		[controller.tabContentView.layer addAnimation:transition forKey:nil];
		
		// the current active view will be hidden in this transition
		activeView.hidden = YES;
		
		// the active view will change to the forecast view
		activeView = forecastView;
		
		// unhide the forecast view
		activeView.hidden = NO;
		
		// change the button also
		activeButton.selected = NO;
		activeButton = sender;
		activeButton.selected = YES;
	}
}

- (IBAction)showImagesView:(UIButton *)sender {
    if(activeView != imagesView) {
		CATransition *transition = [CATransition animation];
		transition.duration = 0.4;
		transition.timingFunction = [CAMediaTimingFunction functionWithName:kCAMediaTimingFunctionEaseInEaseOut];
		transition.type = kCATransitionPush;
		transition.subtype = kCATransitionFromLeft;
		transition.delegate = self;
		
		// Next add it to the containerView's layer. This will perform the transition based on how we change its contents.
		[controller.tabContentView.layer addAnimation:transition forKey:nil];
		
		activeView.hidden = YES;
		activeView = imagesView;
		activeView.hidden = NO;
		
		activeButton.selected = NO;
		activeButton = sender;
		activeButton.selected = YES;
	}
}

- (IBAction)showMoviesView:(UIButton *)sender {
    if(activeView != moviesView) {
		CATransition *transition = [CATransition animation];
		transition.duration = 0.4;
		transition.timingFunction = [CAMediaTimingFunction functionWithName:kCAMediaTimingFunctionEaseInEaseOut];
		transition.type = kCATransitionPush;
		if(activeView == imagesView)
			transition.subtype = kCATransitionFromRight;
		else
			transition.subtype = kCATransitionFromLeft;
		transition.delegate = self;
		
		// Next add it to the containerView's layer. This will perform the transition based on how we change its contents.
		[controller.tabContentView.layer addAnimation:transition forKey:nil];
		
		activeView.hidden = YES;
		activeView = moviesView;
		activeView.hidden = NO;
		
		activeButton.selected = NO;
		activeButton = sender;
		activeButton.selected = YES;
	}
}


- (void)dataSourceDidStartLoading:(JSONDataSource*)ds {
	
}
- (void)dataSourceDidFinishLoading:(JSONDataSource*)ds {
	if(ds == ((SMAppDelegate*)[UIApplication sharedApplication].delegate).imagesDataSource) {
		[(SMImagesDataSource*)ds preloadImages];
	}
	[self tablesNeedUpdate];
	/*srand([[NSDate date] timeIntervalSince1970]);
	NSArray* data = [appDelegate.imagesDataSource thumbnails];
	int r = rand() % [data count];
	NSDictionary* dataItem = [data objectAtIndex:r];
	controller.defaultImage*/
}


#pragma mark UITableView data source methods

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
    return 1;
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
	if(tableView == imagesTable || tableView == moviesTable) {
		SMAppDelegate* appDelegate = (SMAppDelegate *)([UIApplication sharedApplication].delegate);
		return [[appDelegate.imagesDataSource thumbnails] count];
	}
	else if(tableView == forecastTable) {
		SMAppDelegate* appDelegate = (SMAppDelegate *)([UIApplication sharedApplication].delegate);
		return [[(NSDictionary*)[appDelegate.imagesDataSource jsonObject] allKeys] count];
	}
	else {
		return 0;
	}
	
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    static NSString *CellIdentifier = @"SMListCell";
	SMListCell* cell = (SMListCell *)[tableView dequeueReusableCellWithIdentifier:CellIdentifier];
	
	if(cell == nil) {
		[[NSBundle mainBundle] loadNibNamed:@"SMListCell" owner:self options:nil];
        cell = tmpCell;
        self.tmpCell = nil;
	}
	
    //SMSmallARListCell* cell = [[[SMSmallARListCell alloc] initWithFrame:CGRectZero reuseIdentifier:CellIdentifier] autorelease];
    
	// Display dark and light background in alternate rows -- see tableView:willDisplayCell:forRowAtIndexPath:.
	cell.useDarkBackground = (indexPath.row % 2 == 0);	
	// Configure the data for the cell.
	
	SMAppDelegate* appDelegate = (SMAppDelegate *)([UIApplication sharedApplication].delegate);
	if(tableView == imagesTable || tableView == moviesTable) {
		NSArray* data = [appDelegate.imagesDataSource thumbnails];
		NSDictionary *dataItem = [data objectAtIndex:indexPath.row];
		UIImage* img = [[appDelegate.imagesDataSource preloadedImages] objectForKey:[dataItem objectForKey:@"type"]];
		if(img == nil) {
			cell.activity.hidden = NO;
			[cell.activity startAnimating];
			cell.image.hidden = YES;
		}
		else {
			cell.image.hidden = NO;
			cell.activity.hidden = YES;
			cell.image.image = img;
			//cell.image.image = [[[UIApplication sharedApplication] delegate] maskImage:img withMask:[UIImage imageNamed:@"mask.png"]];
		}
		cell.type.text = [dataItem objectForKey:@"type"];
		cell.time.text = [dataItem objectForKey:@"time"];
	}
	else if(tableView == forecastTable) {
		NSDictionary* data = (NSDictionary*)[appDelegate.forecastDataSource jsonObject];
		NSArray* keys = [data allKeys];
		NSDictionary* dataItem = [data objectForKey:[keys objectAtIndex:indexPath.row]];
		UIImage* img = [UIImage imageNamed:[dataItem objectForKey:@"image"]];
		cell.image.image = img;
		cell.image.hidden = NO;
		cell.activity.hidden = YES;
		cell.type.text = [dataItem objectForKey:@"name"];
		cell.time.text = [dataItem objectForKey:@"date"];
	}
    return cell;
}

- (void)tableView:(UITableView *)tableView willDisplayCell:(UITableViewCell *)cell forRowAtIndexPath:(NSIndexPath *)indexPath
{
    cell.backgroundColor = ((SMListCell *)cell).useDarkBackground ? CELL_DARK_BACKGROUND : CELL_LIGHT_BACKGROUND;
}

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
	SMAppDelegate* appDelegate = (SMAppDelegate*)[[UIApplication sharedApplication] delegate];
    [tableView deselectRowAtIndexPath:indexPath animated:YES];
	if(tableView == imagesTable) {
		NSArray* data = [appDelegate.imagesDataSource thumbnails];
		NSDictionary *dataItem = [data objectAtIndex:indexPath.row];
		[controller showImageDetailViewWithData:dataItem];
	} else if(tableView == moviesTable) {
		NSArray* data = [appDelegate.imagesDataSource thumbnails];
		NSDictionary *dataItem = [data objectAtIndex:indexPath.row];
		[controller showMovieCreatorForType:[dataItem valueForKey:@"type"]];
	} else if(tableView == forecastTable) {
		NSDictionary* data = (NSDictionary*)[appDelegate.forecastDataSource jsonObject];
		NSArray* keys = [data allKeys];
		NSDictionary* dataItem = [data objectForKey:[keys objectAtIndex:indexPath.row]];
		[controller showForecastViewWithData:dataItem];
	}
}
- (void)tablesNeedUpdate {
	UITableView* tableView;
	NSArray* tables = [NSArray arrayWithObjects:imagesTable,moviesTable,forecastTable,nil];
	for (tableView in tables) {
		[tableView reloadData];
	}
}

@end
