//
//  SMForecastViewController.m
//  SolMate
//
//  Created by Simon Free on 28/06/2010.
//  Copyright 2010 SolarMonitor.org. All rights reserved.
//

#import "SMForecastViewController.h"


@implementation SMForecastViewController
@synthesize forecastName, forecastDate, forecastText;
- (void)viewDidLoad {
	[super viewDidLoad];
	self.forecastDate.text = [data objectForKey:@"date"];
	self.forecastName.text = [data objectForKey:@"name"];
	self.forecastText.text = [data objectForKey:@"text"];
	
}
- (void)showForecastWithData:(NSDictionary *)dict {
	data = dict;
}
- (IBAction)back {
	[self.delegate flipsideViewControllerDidFinish:self];
}
@end
