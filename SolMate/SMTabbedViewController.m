//
//  SMTabbedViewController.m
//
//  Created by Simon Free on 10/06/2010.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
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
	activeView = imagesView;
	activeButton = imagesButton;
	[activeButton setSelected:YES];
	for(UIView* v in [NSArray arrayWithObjects:imagesView,moviesView,forecastView,nil]) {
		[controller.tabContentView addSubview:v];
		v.hidden = YES;
	}
	activeView.hidden = NO;
	
	UITableView* tableView;
	NSArray* tables = [NSArray arrayWithObjects:imagesTable,moviesTable,forecastTable,nil];
	for (tableView in tables) {
		tableView.rowHeight = 73.0;
		tableView.backgroundColor = CELL_DARK_BACKGROUND;
		tableView.separatorStyle = UITableViewCellSeparatorStyleNone;
	}
}
- (IBAction)showForecastView:(UIButton *)sender {
	if(activeView != forecastView) {
		CATransition *transition = [CATransition animation];
		transition.duration = 0.4;
		transition.timingFunction = [CAMediaTimingFunction functionWithName:kCAMediaTimingFunctionEaseInEaseOut];
		transition.type = kCATransitionPush;
		transition.subtype = kCATransitionFromRight;
		transition.delegate = self;
		
		// Next add it to the containerView's layer. This will perform the transition based on how we change its contents.
		[controller.tabContentView.layer addAnimation:transition forKey:nil];
		
		activeView.hidden = YES;
		activeView = forecastView;
		activeView.hidden = NO;
		
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
    return cell;
}

- (void)tableView:(UITableView *)tableView willDisplayCell:(UITableViewCell *)cell forRowAtIndexPath:(NSIndexPath *)indexPath
{
    cell.backgroundColor = ((SMListCell *)cell).useDarkBackground ? CELL_DARK_BACKGROUND : CELL_LIGHT_BACKGROUND;
}

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    [tableView deselectRowAtIndexPath:indexPath animated:YES];
	if(tableView == imagesTable) {
		SMAppDelegate* appDelegate = (SMAppDelegate*)[[UIApplication sharedApplication] delegate];
		NSArray* data = [appDelegate.imagesDataSource thumbnails];
		NSDictionary *dataItem = [data objectAtIndex:indexPath.row];
		[controller showImageDetailViewWithData:dataItem];
	} else if(tableView == moviesTable) {
		SMAppDelegate* appDelegate = (SMAppDelegate*)[[UIApplication sharedApplication] delegate];
		NSArray* data = [appDelegate.imagesDataSource thumbnails];
		NSDictionary *dataItem = [data objectAtIndex:indexPath.row];
		[controller showMovieCreatorForType:[dataItem valueForKey:@"type"]];
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
