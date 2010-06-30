//
//  SMForecastViewController.h
//  SolMate
//
//  Created by Simon Free on 28/06/2010.
//  Copyright 2010 SolarMonitor.org. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "SMFlipsideViewController.h"


@interface SMForecastViewController : SMFlipsideViewController {
	NSDictionary* data;
}
- (void)showForecastWithData:(NSDictionary *)dict;
- (IBAction)back;
@property (nonatomic, retain) IBOutlet UILabel* forecastName;
@property (nonatomic, retain) IBOutlet UILabel* forecastDate;
@property (nonatomic, retain) IBOutlet UITextView* forecastText;
@end
