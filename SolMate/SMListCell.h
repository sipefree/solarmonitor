//
//  SMListCell.h
//
//  Created by Simon Free on 10/06/2010.
//  Copyright 2010 SolarMonitor.org. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <Foundation/Foundation.h>

@interface SMListCell : UITableViewCell {
    IBOutlet UIImageView *image;
    IBOutlet UILabel *time;
    IBOutlet UILabel *type;
	IBOutlet UIActivityIndicatorView* activity;
	BOOL useDarkBackground;
	
}
@property BOOL useDarkBackground;
@property (nonatomic, assign) UIImageView *image;
@property (nonatomic, assign) UILabel *time;
@property (nonatomic, assign) UILabel *type;
@property (nonatomic, assign) UIActivityIndicatorView *activity;
@end
