//
//  FlipsideViewController.m
//  UtilityTest
//
//  Created by Simon Free on 08/06/2010.
//  Copyright SolarMonitor.org 2010. All rights reserved.
//

#import "SMFlipsideViewController.h"


@implementation SMFlipsideViewController

@synthesize delegate;


- (void)viewDidLoad {
    [super viewDidLoad];
}


- (IBAction)done {
	[self.delegate flipsideViewControllerDidFinish:self];	
}


- (void)didReceiveMemoryWarning {
	// Releases the view if it doesn't have a superview.
    [super didReceiveMemoryWarning];
	
	// Release any cached data, images, etc that aren't in use.
}


- (void)viewDidUnload {
	// Release any retained subviews of the main view.
	// e.g. self.myOutlet = nil;
}


/*
// Override to allow orientations other than the default portrait orientation.
- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation {
	// Return YES for supported orientations
	return (interfaceOrientation == UIInterfaceOrientationPortrait);
}
*/


- (void)dealloc {
    [super dealloc];
}


@end
