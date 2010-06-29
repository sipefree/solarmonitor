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
- (void)showForecastWithData:(NSDictionary *)dict {
	self.forecastDate = [dict objectForKey:@"date"];
	self.forecastName = [dict objectForKey:@"name"];
	self.forecastText = [dict objectForKey:@"text"];
}
- (IBAction)back {
	[self.delegate flipsideViewControllerDidFinish:self];
}
@end
