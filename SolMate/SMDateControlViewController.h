//
//  SMDateControlViewController.h
//
//  Created by Simon Free on 14/06/2010.
//  Copyright 2010 SolarMonitor.org. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <Foundation/Foundation.h>
#import "SMFlipsideViewController.h"

@interface SMDateControlViewController : SMFlipsideViewController {
    IBOutlet UIDatePicker *datePicker;
    IBOutlet UIBarButtonItem *rotateBackButton;
    IBOutlet UIBarButtonItem *rotateForwardButton;
    IBOutlet UIBarButtonItem *weekBackButton;
    IBOutlet UIBarButtonItem *weekForwardButton;
}

@end
